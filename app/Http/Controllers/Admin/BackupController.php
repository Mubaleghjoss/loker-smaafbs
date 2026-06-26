<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BackupController extends Controller
{
    /**
     * Download SQLite database file directly.
     */
    public function downloadSqlite()
    {
        $dbPath = database_path('database.sqlite');

        if (!file_exists($dbPath)) {
            return back()->with('error', 'File database SQLite tidak ditemukan.');
        }

        $filename = 'lokersmaafb_' . date('Y-m-d') . '.sqlite';

        return response()->download($dbPath, $filename, [
            'Content-Type' => 'application/x-sqlite3',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
        ]);
    }

    /**
     * Export all tables as MySQL-compatible SQL file with CREATE TABLE + INSERT.
     */
    public function exportMysql(Request $request)
    {
        $tables = $this->getAppTables();

        $sql  = "-- ============================================\n";
        $sql .= "-- Backup Database Rekrutmen Guru SMA AFBS\n";
        $sql .= "-- Exported: " . now()->format('Y-m-d H:i:s') . "\n";
        $sql .= "-- Source: SQLite -> MySQL\n";
        $sql .= "-- ============================================\n\n";
        $sql .= "SET NAMES utf8mb4;\n";
        $sql .= "SET FOREIGN_KEY_CHECKS = 0;\n";
        $sql .= "SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO,ALLOW_INVALID_DATES';\n";
        $sql .= "SET time_zone = '+07:00';\n\n";

        foreach ($tables as $table) {
            $sql .= $this->generateCreateTable($table);
            $sql .= $this->generateInserts($table);
        }

        $sql .= "SET FOREIGN_KEY_CHECKS = 1;\n";
        $sql .= "-- END OF EXPORT\n";

        $filename = 'lokersmaafb_' . date('Y-m-d') . '.sql';

        // Write to temp file for reliable download with proper filename
        $tempPath = storage_path('app/' . $filename);
        file_put_contents($tempPath, $sql);

        return response()->download($tempPath, $filename, [
            'Content-Type' => 'application/sql; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
        ])->deleteFileAfterSend(true);
    }

    /**
     * Get relevant application tables (skip Laravel internals).
     */
    private function getAppTables(): array
    {
        $all = DB::select("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%' ORDER BY name");
        $tables = [];

        $skipTables = [
            'migrations', 'password_reset_tokens', 'failed_jobs',
            'cache', 'cache_locks', 'jobs', 'job_batches',
            'personal_access_tokens', 'sessions',
        ];

        foreach ($all as $row) {
            if (!in_array($row->name, $skipTables, true)) {
                $tables[] = $row->name;
            }
        }

        return $tables;
    }

    /**
     * Generate CREATE TABLE statement for MySQL from SQLite table info.
     */
    private function generateCreateTable(string $table): string
    {
        $columns = DB::select("PRAGMA table_info(\"{$table}\")");
        if (empty($columns)) {
            return "-- Table `{$table}`: tidak bisa membaca struktur\n\n";
        }

        $sql  = "-- ----------------------------------------\n";
        $sql .= "-- Struktur tabel `{$table}`\n";
        $sql .= "-- ----------------------------------------\n";
        $sql .= "DROP TABLE IF EXISTS `{$table}`;\n";
        $sql .= "CREATE TABLE `{$table}` (\n";

        $colDefs = [];
        $primaryKeys = [];

        foreach ($columns as $col) {
            $mysqlType = $this->sqliteTypeToMysql($col->type, $col->name);
            $nullable = $col->notnull ? ' NOT NULL' : ' DEFAULT NULL';
            $default = '';

            if ($col->dflt_value !== null) {
                $dv = $col->dflt_value;
                // Strip surrounding quotes that SQLite may add
                if (preg_match("/^'(.*)'$/s", $dv, $m)) {
                    $dv = $m[1];
                }
                // Clean up SQLite defaults
                if (strtoupper($dv) === 'NULL') {
                    $default = ' DEFAULT NULL';
                    $nullable = '';
                } elseif (in_array(strtoupper($dv), [
                    'CURRENT_TIMESTAMP', 'CURRENT_DATE', 'CURRENT_TIME',
                    'NOW()', 'UTC_TIMESTAMP', 'UTC_TIMESTAMP()',
                ], true)) {
                    // MySQL keywords/expressions — must NOT be quoted
                    $default = ' DEFAULT ' . strtoupper($dv);
                } elseif (is_numeric($dv)) {
                    $default = " DEFAULT {$dv}";
                } else {
                    $default = " DEFAULT '" . addslashes($dv) . "'";
                }
                $nullable = $col->notnull ? ' NOT NULL' : '';
            }

            // Auto increment for primary key integer
            $autoInc = '';
            if ($col->pk && strtoupper($col->type) === 'INTEGER') {
                $autoInc = ' AUTO_INCREMENT';
                $nullable = ' NOT NULL';
                $default = '';
            }

            if ($col->pk) {
                $primaryKeys[] = $col->name;
            }

            $colDefs[] = "  `{$col->name}` {$mysqlType}{$nullable}{$default}{$autoInc}";
        }

        $sql .= implode(",\n", $colDefs);

        if (!empty($primaryKeys)) {
            $pkList = '`' . implode('`, `', $primaryKeys) . '`';
            $sql .= ",\n  PRIMARY KEY ({$pkList})";
        }

        // Check for indexes
        $indexes = DB::select("PRAGMA index_list(\"{$table}\")");
        foreach ($indexes as $idx) {
            if (str_starts_with($idx->name, 'sqlite_')) continue;
            $idxCols = DB::select("PRAGMA index_info(\"{$idx->name}\")");
            $idxColNames = array_map(fn($c) => "`{$c->name}`", $idxCols);
            $unique = $idx->unique ? 'UNIQUE ' : '';
            $sql .= ",\n  {$unique}KEY `{$idx->name}` (" . implode(', ', $idxColNames) . ")";
        }

        $sql .= "\n) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;\n\n";

        return $sql;
    }

    /**
     * Convert SQLite type to MySQL type.
     */
    private function sqliteTypeToMysql(string $sqliteType, string $colName): string
    {
        $type = strtoupper(trim($sqliteType));

        // Handle VARCHAR(N)
        if (preg_match('/VARCHAR\((\d+)\)/i', $type, $m)) {
            return "VARCHAR({$m[1]})";
        }

        return match (true) {
            $type === 'INTEGER' => 'BIGINT UNSIGNED',
            $type === 'TEXT' => 'TEXT',
            $type === 'REAL', $type === 'FLOAT', $type === 'DOUBLE' => 'DOUBLE',
            $type === 'BLOB' => 'BLOB',
            $type === 'BOOLEAN' => 'TINYINT(1)',
            $type === 'DATETIME', $type === 'TIMESTAMP' => 'DATETIME',
            $type === 'DATE' => 'DATE',
            $type === 'NUMERIC' => 'DECIMAL(20,6)',
            str_contains($type, 'INT') => 'BIGINT',
            str_contains($type, 'CHAR') => 'VARCHAR(255)',
            str_contains($type, 'TEXT') => 'TEXT',
            str_contains($type, 'BOOL') => 'TINYINT(1)',
            str_contains($type, 'DATE') || str_contains($type, 'TIME') => 'DATETIME',
            default => 'VARCHAR(255)',
        };
    }

    /**
     * Generate INSERT statements for a table.
     */
    private function generateInserts(string $table): string
    {
        $rows = DB::select("SELECT * FROM \"{$table}\"");
        if (empty($rows)) {
            return "-- Data `{$table}`: 0 rows (kosong)\n\n";
        }

        $sql  = "-- Data `{$table}`: " . count($rows) . " rows\n";

        $columns = array_keys((array)$rows[0]);
        $colList = '`' . implode('`, `', $columns) . '`';

        // Batch insert (100 per batch)
        $batches = array_chunk($rows, 100);
        foreach ($batches as $batch) {
            $sql .= "INSERT INTO `{$table}` ({$colList}) VALUES\n";
            $values = [];
            foreach ($batch as $row) {
                $vals = [];
                foreach ((array)$row as $v) {
                    if (is_null($v)) {
                        $vals[] = 'NULL';
                    } elseif (is_numeric($v) && !str_starts_with((string)$v, '0')) {
                        $vals[] = $v;
                    } else {
                        $escaped = str_replace(
                            ['\\', "'", "\0", "\n", "\r", "\x1a"],
                            ['\\\\', "\\'", '\\0', '\\n', '\\r', '\\Z'],
                            (string)$v
                        );
                        $vals[] = "'" . $escaped . "'";
                    }
                }
                $values[] = '(' . implode(', ', $vals) . ')';
            }
            $sql .= implode(",\n", $values) . ";\n\n";
        }

        return $sql;
    }
}
