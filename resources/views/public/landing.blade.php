@extends('layouts.app')

@section('content')
    <div class="grid gap-6 lg:grid-cols-5">
        {{-- Hero Section --}}
        <div class="lg:col-span-3 animate-fade-in-up">
            <div class="relative overflow-hidden rounded-2xl p-8 text-white shadow-card sm:p-10" style="background: var(--brand-gradient);">
                {{-- Background blobs --}}
                <div class="absolute -right-16 -top-16 h-64 w-64 rounded-full bg-white/10 blur-3xl"></div>
                <div class="absolute -bottom-20 -left-20 h-48 w-48 rounded-full bg-white/15 blur-3xl"></div>

                <div class="relative">
                    <div class="inline-flex items-center gap-2 rounded-full bg-white/15 px-3 py-1 text-xs font-medium backdrop-blur">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-300 animate-pulse"></span>
                        Sedang membuka lowongan
                    </div>

                    <h1 class="mt-5 font-display text-3xl font-extrabold tracking-tight sm:text-4xl">
                        {!! nl2br(e(str_replace('\n', "\n", \App\Models\Setting::getValue('hero_title', "Rekrutmen Guru\nSMA AFBS")))) !!}
                    </h1>
                    <p class="mt-3 max-w-md text-white/80 leading-relaxed">
                        {{ \App\Models\Setting::getValue('hero_description', 'Bergabunglah bersama kami membangun pendidikan berkualitas. Daftar sekarang dan jadilah bagian dari keluarga SMA Al Furqon Boarding School.') }}
                    </p>

                    <div class="mt-8 grid gap-3 sm:grid-cols-2">
                        <div class="flex items-start gap-3 rounded-xl bg-white/10 p-4 backdrop-blur">
                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-white/20">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <div class="text-sm font-semibold">Benefit</div>
                                <div class="mt-0.5 text-xs text-white/70">Lingkungan islami, pengembangan kompetensi berkelanjutan</div>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 rounded-xl bg-white/10 p-4 backdrop-blur">
                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-white/20">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                            </div>
                            <div>
                                <div class="text-sm font-semibold">Proses</div>
                                <div class="mt-0.5 text-xs text-white/70">Daftar → Verifikasi → Interview → Keputusan</div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex flex-wrap gap-3">
                        <a href="{{ route('applications.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-white px-5 py-2.5 text-sm font-bold shadow-lg transition-all hover:shadow-xl hover:-translate-y-0.5" style="color: var(--brand-primary)">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                            Daftar Sekarang
                        </a>
                        <a href="{{ route('status.form') }}" class="inline-flex items-center gap-2 rounded-xl border border-white/30 bg-white/10 px-5 py-2.5 text-sm font-semibold backdrop-blur transition-all hover:bg-white/20">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            Cek Status
                        </a>
                        <a href="{{ route('admin.login') }}" class="inline-flex items-center gap-2 rounded-xl border border-white/40 bg-slate-950/25 px-5 py-2.5 text-sm font-semibold text-white backdrop-blur transition-all hover:bg-slate-950/35">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 7a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M4 20a8 8 0 0116 0"/></svg>
                            Login Admin/Panitia
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Posisi Dibuka --}}
        <div class="lg:col-span-2 animate-fade-in-up delay-2">
            <div class="card p-6">
                <div class="flex items-center justify-between">
                    <h2 class="font-display text-lg font-bold text-slate-900">Posisi Dibuka</h2>
                    <span class="inline-flex items-center gap-1 rounded-full bg-brand-light px-3 py-1 text-xs font-semibold text-brand">
                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        {{ $positions->count() }} posisi
                    </span>
                </div>

                <div class="mt-4 space-y-3 max-h-[600px] overflow-y-auto scrollbar-hide pr-1">
                    @forelse ($positions as $position)
                        <div data-animate="fade-up" class="group rounded-xl border border-slate-100 p-4 transition-all hover:border-brand-light hover:shadow-soft">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <div class="font-semibold text-slate-900 group-hover:text-brand transition-colors">{{ $position->name }}</div>
                                    @if ($position->description)
                                        <div class="mt-1 text-sm text-slate-500">{{ $position->description }}</div>
                                    @endif
                                </div>
                                <a href="{{ route('applications.create', ['position' => $position->slug]) }}" class="btn-primary shrink-0 !px-3 !py-1.5 !text-xs">
                                    Daftar
                                </a>
                            </div>

                            @if ($position->requirements)
                                @php($reqLines = array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $position->requirements) ?: []))))
                                @if (count($reqLines))
                                    <details class="mt-3 group/details">
                                        <summary class="cursor-pointer text-xs font-semibold text-brand hover:text-brand-secondary select-none flex items-center gap-1">
                                            <svg class="h-3 w-3 transition-transform group-open/details:rotate-90" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                                            Persyaratan melamar
                                        </summary>
                                        <ul class="mt-2 space-y-1 pl-4 text-xs text-slate-600 list-disc">
                                            @foreach ($reqLines as $line)
                                                <li>{{ $line }}</li>
                                            @endforeach
                                        </ul>
                                    </details>
                                @endif
                            @endif
                        </div>
                    @empty
                        <div class="rounded-xl bg-slate-50 p-5 text-center text-sm text-slate-500">
                            <svg class="mx-auto h-8 w-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                            <div class="mt-2">Saat ini belum ada posisi yang dibuka.</div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
