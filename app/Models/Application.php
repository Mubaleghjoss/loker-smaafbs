<?php

namespace App\Models;

use App\Enums\ApplicationStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Application extends Model
{
    protected $fillable = [
        'registration_code',
        'position_id',
        'position_title',
        'full_name',
        'email',
        'birth_place',
        'birth_date',
        'address',
        'domicile',
        'whatsapp',
        'last_education',
        'major',
        'campus',
        'connected_address',
        'expected_salary',
        'cv_path',
        'diploma_path',
        'status',
        'public_note',
        'internal_note',
        'submitted_ip',
        'submitted_user_agent',
        'submitted_at',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'expected_salary' => 'integer',
        'submitted_at' => 'datetime',
    ];

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    public function statusEnum(): ApplicationStatus
    {
        return ApplicationStatus::from($this->status);
    }

    public static function generateRegistrationCode(): string
    {
        return 'AFBS-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6));
    }

    protected static function booted(): void
    {
        static::creating(function (self $application) {
            if (!$application->registration_code) {
                $application->registration_code = static::generateRegistrationCode();
            }
        });
    }
}
