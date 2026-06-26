<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ApplicationStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateApplicationStatusRequest;
use App\Models\Application;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ApplicantController extends Controller
{
    public function index(Request $request)
    {
        $positions = Position::query()
            ->orderByDesc('is_active')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $query = Application::query()->orderByDesc('submitted_at');

        if ($request->filled('position_id')) {
            $query->where('position_id', $request->string('position_id')->toString());
        }

        if ($request->filled('status')) {
            $query->where('status', $request->string('status')->toString());
        }

        if ($request->filled('q')) {
            $q = $request->string('q')->toString();
            $query->where(function ($sub) use ($q) {
                $sub->where('registration_code', 'like', "%{$q}%")
                    ->orWhere('full_name', 'like', "%{$q}%")
                    ->orWhere('whatsapp', 'like', "%{$q}%");
            });
        }

        if ($request->filled('from')) {
            $query->whereDate('submitted_at', '>=', $request->string('from')->toString());
        }

        if ($request->filled('to')) {
            $query->whereDate('submitted_at', '<=', $request->string('to')->toString());
        }

        $applications = $query->paginate(20)->withQueryString();

        return view('admin.applicants.index', [
            'applications' => $applications,
            'positions' => $positions,
            'statuses' => ApplicationStatus::cases(),
        ]);
    }

    public function show(Application $application)
    {
        return view('admin.applicants.show', [
            'application' => $application,
            'statuses' => ApplicationStatus::cases(),
        ]);
    }

    public function updateStatus(UpdateApplicationStatusRequest $request, Application $application)
    {
        $data = $request->validated();

        $application->update([
            'status' => $data['status'],
            'public_note' => $data['public_note'] ?? null,
            'internal_note' => $data['internal_note'] ?? null,
        ]);

        return back()->with('success', 'Status lamaran berhasil diperbarui.');
    }

    public function downloadFile(Application $application, string $type)
    {
        $type = strtolower($type);

        $path = match ($type) {
            'cv' => $application->cv_path,
            'ijazah', 'diploma' => $application->diploma_path,
            default => null,
        };

        if (!$path || !Storage::disk('local')->exists($path)) {
            abort(404);
        }

        $downloadName = $type === 'cv'
            ? 'CV-' . $application->registration_code . '.pdf'
            : 'Ijazah-' . $application->registration_code . '.' . pathinfo($path, PATHINFO_EXTENSION);

        $fullPath = Storage::disk('local')->path($path);

        return response()->download($fullPath, $downloadName);
    }

    public function previewFile(Application $application, string $type): BinaryFileResponse
    {
        $type = strtolower($type);

        $path = match ($type) {
            'cv' => $application->cv_path,
            'ijazah', 'diploma' => $application->diploma_path,
            default => null,
        };

        if (!$path || !Storage::disk('local')->exists($path)) {
            abort(404);
        }

        $fullPath = Storage::disk('local')->path($path);

        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        $mime = match ($ext) {
            'pdf' => 'application/pdf',
            'jpg', 'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            default => 'application/octet-stream',
        };

        // Inline preview (new tab) untuk PDF dan gambar.
        // Catatan: jika browser tidak punya PDF viewer, tetap bisa terunduh.
        return response()->file($fullPath, [
            'Content-Type' => $mime,
            'Content-Disposition' => 'inline; filename="' . basename($path) . '"',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    public function exportCsv(Request $request)
    {
        $query = Application::query()->orderByDesc('submitted_at');

        if ($request->filled('position_id')) {
            $query->where('position_id', $request->string('position_id')->toString());
        }

        if ($request->filled('status')) {
            $query->where('status', $request->string('status')->toString());
        }

        if ($request->filled('from')) {
            $query->whereDate('submitted_at', '>=', $request->string('from')->toString());
        }

        if ($request->filled('to')) {
            $query->whereDate('submitted_at', '<=', $request->string('to')->toString());
        }

        $fileName = 'pelamar-' . now()->format('Ymd-His') . '.csv';

        return response()->streamDownload(function () use ($query) {
            $out = fopen('php://output', 'w');

            fputcsv($out, [
                'Kode',
                'Nama',
                'Posisi',
                'WA',
                'Domisili',
                'Pendidikan',
                'Kampus',
                'Status',
                'Tanggal Submit',
            ]);

            $query->chunk(500, function ($rows) use ($out) {
                foreach ($rows as $a) {
                    fputcsv($out, [
                        $a->registration_code,
                        $a->full_name,
                        $a->position_title,
                        $a->whatsapp,
                        $a->domicile,
                        $a->last_education,
                        $a->campus,
                        $a->status,
                        optional($a->submitted_at)->format('Y-m-d H:i:s'),
                    ]);
                }
            });

            fclose($out);
        }, $fileName, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}
