@extends('layouts.app')

@section('content')
    <div class="grid gap-6 lg:grid-cols-2">
        {{-- Search --}}
        <div class="animate-fade-in-up">
            <div class="card p-6">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-brand-gradient">
                        <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <div>
                        <h1 class="font-display text-xl font-bold text-slate-900">Cek Status Lamaran</h1>
                        <p class="text-sm text-slate-500">Masukkan kode pendaftaran Anda</p>
                    </div>
                </div>

                <form method="post" action="{{ route('status.check') }}" class="mt-5">
                    @csrf
                    <div class="flex gap-2">
                        <input name="code" value="{{ old('code', $code) }}" placeholder="AFBS-20260112-XXXXXX" class="input-modern flex-1" required />
                        <button class="btn-primary shrink-0">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            Cek
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Result --}}
        <div class="animate-fade-in-up delay-2">
            <div class="card p-6">
                <h2 class="font-display text-lg font-bold text-slate-900">Hasil</h2>

                @if (!$code)
                    <div class="mt-4 flex flex-col items-center rounded-xl bg-slate-50 p-6 text-center">
                        <svg class="h-12 w-12 text-slate-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <div class="mt-3 text-sm text-slate-500">Masukkan kode pendaftaran untuk melihat status.</div>
                    </div>
                @elseif (!$application)
                    <div class="mt-4 flex items-start gap-3 rounded-xl border border-rose-200/60 bg-gradient-to-r from-rose-50 to-pink-50 p-4">
                        <div class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-rose-500">
                            <svg class="h-3.5 w-3.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        </div>
                        <div class="text-sm text-rose-800">Kode tidak ditemukan. Pastikan kode pendaftaran benar.</div>
                    </div>
                @else
                    @php
                        $status = $application->statusEnum();
                        $adminWa = \App\Models\Setting::getValue('admin_whatsapp', '+6283818393029');
                        $waNum = preg_replace('/[^0-9]/', '', $adminWa);
                        $statusUrl = route('status.form', ['code' => $application->registration_code]);
                        $waMsg = "Assalamu'alaikum Wr. Wb.\n\n" .
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
                        $waLink = 'https://wa.me/' . $waNum . '?text=' . urlencode($waMsg);
                    @endphp
                    <div class="mt-4 space-y-3" data-animate="fade-up">
                        <div class="rounded-xl border border-slate-100 bg-slate-50/50 p-4">
                            <div class="text-xs font-medium text-slate-400 uppercase tracking-wider">Nama</div>
                            <div class="mt-1 font-semibold text-slate-900">{{ $application->full_name }}</div>
                        </div>
                        <div class="rounded-xl border border-slate-100 bg-slate-50/50 p-4">
                            <div class="text-xs font-medium text-slate-400 uppercase tracking-wider">Posisi</div>
                            <div class="mt-1 font-semibold text-slate-900">{{ $application->position_title }}</div>
                        </div>
                        <div class="rounded-xl border border-slate-100 bg-slate-50/50 p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-xs font-medium text-slate-400 uppercase tracking-wider">Status</div>
                                    <div class="mt-2 inline-flex items-center rounded-full px-3 py-1 text-xs font-bold ring-1 {{ $status->badgeClasses() }}">
                                        {{ $status->label() }}
                                    </div>
                                </div>
                                <div class="text-xs text-slate-400">{{ optional($application->submitted_at)->format('d/m/Y H:i') }}</div>
                            </div>
                        </div>

                        @if ($application->public_note)
                            <div class="flex items-start gap-3 rounded-xl border border-amber-200/60 bg-gradient-to-r from-amber-50 to-yellow-50 p-4">
                                <div class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-amber-500">
                                    <svg class="h-3.5 w-3.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-amber-900">Catatan</div>
                                    <div class="mt-0.5 text-sm text-amber-800">{{ $application->public_note }}</div>
                                </div>
                            </div>
                        @endif

                        {{-- Chat Admin WhatsApp --}}
                        <a href="{{ $waLink }}" target="_blank" rel="noopener" class="flex items-center justify-center gap-2 rounded-xl bg-emerald-500 px-5 py-3 text-sm font-bold text-white shadow-lg transition-all hover:bg-emerald-600 hover:shadow-xl hover:-translate-y-0.5">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            Chat Admin via WhatsApp
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
