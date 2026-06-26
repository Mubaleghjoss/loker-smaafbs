<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\ApplicationStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreApplicationRequest;
use App\Mail\ApplicationSubmittedMail;
use App\Models\Application;
use App\Models\Position;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ApplicationController extends Controller
{
    public function create()
    {
        $positions = Position::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $prefillPositionId = null;
        $prefillPositionTitle = '';
        $prefillPositionRequirements = null;

        $positionId = request()->query('position_id');
        $positionSlug = request()->query('position');

        if ($positionId) {
            $position = Position::query()->where('is_active', true)->find($positionId);
            if ($position) {
                $prefillPositionId = $position->id;
                $prefillPositionTitle = $position->name;
                $prefillPositionRequirements = $position->requirements;
            }
        } elseif ($positionSlug) {
            $position = Position::query()->where('is_active', true)->where('slug', $positionSlug)->first();
            if ($position) {
                $prefillPositionId = $position->id;
                $prefillPositionTitle = $position->name;
                $prefillPositionRequirements = $position->requirements;
            }
        }

        return view('public.apply', [
            'positions' => $positions,
            'prefillPositionId' => $prefillPositionId,
            'prefillPositionTitle' => $prefillPositionTitle,
            'prefillPositionRequirements' => $prefillPositionRequirements,
        ]);
    }

    public function store(StoreApplicationRequest $request)
    {
        $validated = $request->validated();

        $position = null;
        if (!empty($validated['position_id'])) {
            $position = Position::query()->find($validated['position_id']);
        }

        $positionTitle = $position ? $position->name : ($validated['position_title'] ?? '');

        // Generate kode dulu supaya folder upload sudah pasti.
        do {
            $registrationCode = Application::generateRegistrationCode();
        } while (Application::query()->where('registration_code', $registrationCode)->exists());

        $folder = 'private/applications/' . $registrationCode;

        $cvName = 'cv-' . Str::lower(Str::random(12)) . '.pdf';
        $cvPath = $request->file('cv')->storeAs($folder, $cvName, 'local');

        $diplomaExt = Str::lower($request->file('diploma')->extension() ?: 'pdf');
        $diplomaName = 'ijazah-' . Str::lower(Str::random(12)) . '.' . $diplomaExt;
        $diplomaPath = $request->file('diploma')->storeAs($folder, $diplomaName, 'local');

        try {
            $application = DB::transaction(function () use ($request, $validated, $position, $positionTitle, $registrationCode, $cvPath, $diplomaPath) {
                $application = new Application();
                $application->registration_code = $registrationCode;
                $application->position_id = $position?->id;
                $application->position_title = $positionTitle;
                $application->full_name = $validated['full_name'];
                $application->email = $validated['email'] ?? null;
                $application->birth_place = $validated['birth_place'];
                $application->birth_date = $validated['birth_date'];
                $application->address = $validated['address'];
                $application->domicile = $validated['domicile'];
                $application->whatsapp = $validated['whatsapp'];
                $application->last_education = $validated['last_education'];
                $application->major = $validated['major'];
                $application->campus = $validated['campus'];
                $application->connected_address = $validated['connected_address'];
                $application->expected_salary = $validated['expected_salary'] ?? null;
                $application->status = ApplicationStatus::Diproses->value;
                $application->submitted_ip = $request->ip();
                $application->submitted_user_agent = $request->userAgent();
                $application->submitted_at = now();
                $application->cv_path = $cvPath;
                $application->diploma_path = $diplomaPath;
                $application->save();

                return $application;
            });
        } catch (\Throwable $e) {
            // Jangan tinggalkan file yatim kalau insert DB gagal.
            Storage::disk('local')->delete([$cvPath, $diplomaPath]);
            throw $e;
        }

        $mailEnabled = Setting::getValue('mail_confirm_enabled', '0') === '1';
        if ($mailEnabled && $application->email) {
            try {
                Mail::to($application->email)->send(new ApplicationSubmittedMail($application));
            } catch (\Throwable $e) {
                Log::warning('Mail confirmation failed: ' . $e->getMessage());
            }
        }

        return redirect()->route('applications.success', ['code' => $application->registration_code]);
    }

    public function success(string $code)
    {
        $application = Application::query()
            ->where('registration_code', $code)
            ->firstOrFail();

        $adminWhatsApp = Setting::getValue('admin_whatsapp', '+6283818393029');
        $waNumber = preg_replace('/[^0-9]/', '', $adminWhatsApp ?? '');

        $statusUrl = route('status.form', ['code' => $application->registration_code]);

        $message = "Assalamu'alaikum Wr. Wb.\n\n" .
            "Dengan hormat,\n" .
            "Bersama ini saya menyampaikan bahwa saya telah mengajukan permohonan lamaran pekerjaan di SMA Al Furqon Boarding School (SMA AFBS) dengan data sebagai berikut:\n\n" .
            "📋 *Data Pelamar*\n" .
            "Nama  : *{$application->full_name}*\n" .
            "Posisi : *{$application->position_title}*\n" .
            "Kode   : *{$application->registration_code}*\n\n" .
            "Saya berharap dapat diberikan kesempatan untuk mengikuti proses seleksi sesuai dengan ketentuan yang berlaku.\n\n" .
            "Atas perhatian dan kesempatannya, saya ucapkan syukur Alhamdulillah Jazaakallahu Khairan dan terima kasih.\n\n" .
            "🔗 Cek status lamaran:\n{$statusUrl}\n\n" .
            "Wassalamu'alaikum Wr. Wb.";

        $waUrl = 'https://wa.me/' . $waNumber . '?text=' . urlencode($message);

        return view('public.success', [
            'application' => $application,
            'waUrl' => $waUrl,
        ]);
    }
}
