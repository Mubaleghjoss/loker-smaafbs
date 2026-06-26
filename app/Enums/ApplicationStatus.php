<?php

namespace App\Enums;

enum ApplicationStatus: string
{
    case Diproses = 'diproses';
    case Diterima = 'diterima';
    case Ditolak = 'ditolak';
    case ButuhBerkas = 'butuh_berkas';

    public function label(): string
    {
        return match ($this) {
            self::Diproses => 'Diproses',
            self::Diterima => 'Diterima',
            self::Ditolak => 'Ditolak',
            self::ButuhBerkas => 'Butuh berkas',
        };
    }

    public function badgeClasses(): string
    {
        return match ($this) {
            self::Diproses => 'bg-sky-100 text-sky-800 ring-sky-200',
            self::Diterima => 'bg-emerald-100 text-emerald-800 ring-emerald-200',
            self::Ditolak => 'bg-rose-100 text-rose-800 ring-rose-200',
            self::ButuhBerkas => 'bg-amber-100 text-amber-900 ring-amber-200',
        };
    }
}
