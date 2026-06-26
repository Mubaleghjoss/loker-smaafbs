<x-mail::message>
# Pendaftaran Berhasil Diterima

Terima kasih sudah mendaftar di Rekrutmen Guru SMA AFBS.

Kode pendaftaran Anda:

**{{ $application->registration_code }}**

<x-mail::button :url="route('status.form', ['code' => $application->registration_code])">
Cek Status Lamaran
</x-mail::button>

Simpan kode ini untuk cek status kapan saja.

Hormat kami,<br>
{{ config('app.name') }}
</x-mail::message>
