@extends('layouts.admin')

@section('content')
    {{-- Header --}}
    <div class="flex flex-wrap items-end justify-between gap-4 animate-fade-in-up">
        <div>
            <h1 class="font-display text-2xl font-bold text-slate-900">Dashboard</h1>
            <p class="mt-1 text-sm text-slate-500">Selamat datang kembali, <span class="font-medium text-slate-700">{{ auth('admin')->user()->name }}</span></p>
        </div>
        <a href="{{ route('admin.applicants.index') }}" class="btn-primary">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Lihat Pelamar
        </a>
    </div>

    {{-- Stat Cards --}}
    <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
        {{-- Total --}}
        <div class="card p-5 animate-fade-in-up delay-1 group hover:shadow-card transition-shadow">
            <div class="flex items-center justify-between">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-slate-700 to-slate-900 text-white shadow-soft">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
            </div>
            <div class="mt-3 text-xs font-medium text-slate-500 uppercase tracking-wider">Total Pelamar</div>
            <div class="mt-1 font-display text-2xl font-extrabold text-slate-900" data-count-up="{{ $totalApplicants }}">0</div>
        </div>

        {{-- Status cards --}}
        @foreach ($statusCards as $i => $card)
            @php
                $gradients = [
                    'diproses' => 'from-sky-500 to-blue-600',
                    'diterima' => 'from-emerald-500 to-teal-600',
                    'ditolak' => 'from-rose-500 to-pink-600',
                    'butuh_berkas' => 'from-amber-500 to-orange-600',
                ];
                $gradient = $gradients[$card['value']] ?? 'from-slate-500 to-slate-600';
            @endphp
            <div class="card p-5 animate-fade-in-up delay-{{ $i + 2 }} group hover:shadow-card transition-shadow">
                <div class="flex items-center justify-between">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br {{ $gradient }} text-white shadow-soft">
                        @if ($card['value'] === 'diproses')
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        @elseif ($card['value'] === 'diterima')
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        @elseif ($card['value'] === 'ditolak')
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        @else
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        @endif
                    </div>
                </div>
                <div class="mt-3 text-xs font-medium text-slate-500 uppercase tracking-wider">{{ $card['label'] }}</div>
                <div class="mt-1 font-display text-2xl font-extrabold text-slate-900" data-count-up="{{ $card['total'] }}">0</div>
            </div>
        @endforeach
    </div>

    {{-- Pelamar per Posisi --}}
    <div class="mt-6 card animate-fade-in-up delay-6">
        <div class="p-6 pb-0">
            <h2 class="font-display text-lg font-bold text-slate-900">Pelamar per Posisi</h2>
            <p class="mt-1 text-sm text-slate-500">Distribusi pelamar berdasarkan posisi aktif</p>
        </div>
        <div class="mt-4 overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-slate-100">
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Posisi</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Proporsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach ($byPosition as $row)
                        <tr class="table-row-hover transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    </div>
                                    <span class="font-medium text-slate-900">{{ $row->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center rounded-full bg-indigo-50 px-2.5 py-0.5 text-sm font-bold text-indigo-700">{{ $row->total }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @php($percentage = $totalApplicants > 0 ? round(($row->total / $totalApplicants) * 100) : 0)
                                <div class="flex items-center gap-3">
                                    <div class="h-2 w-24 overflow-hidden rounded-full bg-slate-100">
                                        <div class="h-full rounded-full bg-brand-gradient transition-all duration-1000" style="width: {{ $percentage }}%"></div>
                                    </div>
                                    <span class="text-xs font-medium text-slate-500">{{ $percentage }}%</span>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pelamar Terbaru --}}
    <div class="mt-6 card animate-fade-in-up delay-7">
        <div class="p-6 pb-0 flex items-center justify-between">
            <div>
                <h2 class="font-display text-lg font-bold text-slate-900">Pelamar Terbaru</h2>
                <p class="mt-1 text-sm text-slate-500">10 pelamar terakhir yang mendaftar</p>
            </div>
            <a href="{{ route('admin.applicants.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800 transition-colors">
                Lihat Semua &rarr;
            </a>
        </div>
        <div class="mt-4 overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-slate-100">
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Posisi</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-slate-500">CV</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-slate-500">Ijazah</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Harapan Gaji</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Status</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-slate-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($latestApplicants as $applicant)
                        <tr class="table-row-hover transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-medium text-slate-900">{{ $applicant->full_name }}</div>
                                <div class="text-xs text-slate-400">{{ $applicant->registration_code }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-700">{{ $applicant->position_title }}</td>
                            <td class="px-6 py-4 text-center">
                                @if ($applicant->cv_path)
                                    <a href="{{ route('admin.applicants.preview', [$applicant->id, 'cv']) }}" target="_blank"
                                       class="inline-flex items-center gap-1 rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 hover:bg-blue-100 transition-colors">
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        Lihat
                                    </a>
                                @else
                                    <span class="text-xs text-slate-300">&mdash;</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if ($applicant->diploma_path)
                                    <a href="{{ route('admin.applicants.preview', [$applicant->id, 'ijazah']) }}" target="_blank"
                                       class="inline-flex items-center gap-1 rounded-md bg-purple-50 px-2 py-1 text-xs font-medium text-purple-700 hover:bg-purple-100 transition-colors">
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        Lihat
                                    </a>
                                @else
                                    <span class="text-xs text-slate-300">&mdash;</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-slate-700">
                                @if ($applicant->expected_salary)
                                    Rp {{ number_format($applicant->expected_salary, 0, ',', '.') }}
                                @else
                                    <span class="text-xs text-slate-300">&mdash;</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold ring-1 ring-inset {{ $applicant->statusEnum()->badgeClasses() }}">
                                    {{ $applicant->statusEnum()->label() }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('admin.applicants.show', $applicant->id) }}"
                                   class="inline-flex items-center gap-1 rounded-md bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-700 hover:bg-slate-200 transition-colors">
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-sm text-slate-400">Belum ada pelamar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
