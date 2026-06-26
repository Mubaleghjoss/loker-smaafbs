@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-lg animate-fade-in-up">
        <div class="card p-8 text-center">
            {{-- Animated checkmark --}}
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 shadow-lg animate-scale-in">
                <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" style="stroke-dasharray:100;animation:checkmark 0.6s ease-out 0.3s both"/>
                </svg>
            </div>

            <h1 class="mt-5 font-display text-2xl font-bold text-slate-900">Pendaftaran Berhasil!</h1>
            <p class="mt-2 text-slate-500">Simpan kode pendaftaran ini untuk cek status lamaran Anda.</p>

            {{-- Registration code --}}
            <div class="mt-6 rounded-xl border p-5 animate-fade-in-up delay-2 border-brand-light bg-brand-lighter">
                <div class="text-xs font-medium uppercase tracking-wider text-brand">Kode Pendaftaran</div>
                <div class="mt-2 font-display text-2xl font-extrabold tracking-tight" style="color: var(--brand-primary)">{{ $application->registration_code }}</div>
                <button onclick="navigator.clipboard.writeText('{{ $application->registration_code }}').then(()=>{this.textContent='✓ Tersalin!';setTimeout(()=>{this.textContent='Salin Kode'},2000)})" class="mt-3 inline-flex items-center gap-1.5 rounded-lg border bg-white px-3 py-1.5 text-xs font-semibold transition-all border-brand-light text-brand hover:bg-brand-light">
                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                    Salin Kode
                </button>
            </div>

            {{-- Actions --}}
            <div class="mt-6 flex flex-col gap-2 sm:flex-row sm:justify-center animate-fade-in-up delay-3">
                <a href="{{ route('status.form', ['code' => $application->registration_code]) }}" class="btn-secondary justify-center">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Cek Status
                </a>
                <a href="{{ $waUrl }}" class="btn-wa justify-center" target="_blank" rel="noopener">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    Chat Admin via WhatsApp
                </a>
            </div>

            <div class="mt-4 text-xs text-slate-400">
                Simpan kode ini. Klik WhatsApp agar lebih cepat ditindaklanjuti.
            </div>
        </div>
    </div>
@endsection
