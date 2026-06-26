@extends('layouts.admin')

@section('content')
    {{-- Header --}}
    <div class="flex flex-wrap items-end justify-between gap-4 animate-fade-in-up">
        <div>
            <h1 class="font-display text-2xl font-bold text-slate-900">Pelamar</h1>
            <p class="mt-1 text-sm text-slate-500">Daftar pelamar dan filter berdasarkan kriteria</p>
        </div>
        <a href="{{ route('admin.applicants.export.csv', request()->query()) }}" class="btn-secondary">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Export CSV
        </a>
    </div>

    {{-- Filters --}}
    <div class="mt-5 card p-5 animate-fade-in-up delay-1">
        <form class="grid gap-3 md:grid-cols-5" method="get" action="{{ route('admin.applicants.index') }}">
            <input name="q" value="{{ request('q') }}" placeholder="Cari kode/nama/WA" class="input-modern" />
            <select name="position_id" class="input-modern">
                <option value="">Semua posisi</option>
                @foreach ($positions as $p)
                    <option value="{{ $p->id }}" @selected((string)request('position_id') === (string)$p->id)>{{ $p->name }}</option>
                @endforeach
            </select>
            <select name="status" class="input-modern">
                <option value="">Semua status</option>
                @foreach ($statuses as $s)
                    <option value="{{ $s->value }}" @selected(request('status') === $s->value)>{{ $s->label() }}</option>
                @endforeach
            </select>
            <input type="date" name="from" value="{{ request('from') }}" class="input-modern" />
            <input type="date" name="to" value="{{ request('to') }}" class="input-modern" />
            <div class="md:col-span-5 flex flex-wrap gap-2">
                <button class="btn-primary">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                    Terapkan
                </button>
                <a href="{{ route('admin.applicants.index') }}" class="btn-secondary">Reset</a>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="mt-5 card overflow-hidden animate-fade-in-up delay-2">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/50">
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Kode</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Nama</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Posisi</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Gaji</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Berkas</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Status</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Tanggal</th>
                        <th class="px-5 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach ($applications as $a)
                        @php($s = $a->statusEnum())
                        <tr class="table-row-hover transition-colors">
                            <td class="px-5 py-3.5">
                                <span class="rounded-md bg-slate-100 px-2 py-0.5 font-mono text-xs font-medium text-slate-600">{{ $a->registration_code }}</span>
                            </td>
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-indigo-400 to-violet-500 text-[10px] font-bold text-white">
                                        {{ strtoupper(substr($a->full_name, 0, 2)) }}
                                    </div>
                                    <span class="font-medium text-slate-900">{{ $a->full_name }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 text-sm text-slate-600">{{ $a->position_title }}</td>
                            <td class="px-5 py-3.5">
                                @if ($a->expected_salary)
                                    <span class="text-sm font-semibold text-emerald-700">Rp {{ number_format($a->expected_salary, 0, ',', '.') }}</span>
                                @else
                                    <span class="text-xs text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.applicants.preview', [$a, 'cv']) }}" target="_blank" class="inline-flex items-center gap-1 rounded-md bg-rose-50 px-2 py-1 text-[11px] font-semibold text-rose-600 hover:bg-rose-100 transition-colors" title="Preview CV">
                                        <svg style="width:12px;height:12px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        CV
                                    </a>
                                    <a href="{{ route('admin.applicants.preview', [$a, 'diploma']) }}" target="_blank" class="inline-flex items-center gap-1 rounded-md bg-blue-50 px-2 py-1 text-[11px] font-semibold text-blue-600 hover:bg-blue-100 transition-colors" title="Preview Ijazah">
                                        <svg style="width:12px;height:12px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        Ijazah
                                    </a>
                                </div>
                            </td>
                            <td class="px-5 py-3.5">
                                <form method="post" action="{{ route('admin.applicants.status', $a) }}" class="inline" onsubmit="return confirm('Ubah status pelamar ini?')">
                                    @csrf
                                    <select name="status" onchange="this.form.submit()" class="rounded-lg border-slate-200 bg-slate-50 px-2 py-1 text-xs font-semibold focus:border-indigo-400 focus:ring-indigo-200 cursor-pointer" style="min-width:120px;">
                                        @foreach ($statuses as $st)
                                            <option value="{{ $st->value }}" @selected($a->status === $st->value)>{{ $st->label() }}</option>
                                        @endforeach
                                    </select>
                                </form>
                            </td>
                            <td class="px-5 py-3.5 text-sm text-slate-500">{{ optional($a->submitted_at)->format('d/m/Y H:i') }}</td>
                            <td class="px-5 py-3.5 text-right">
                                <a href="{{ route('admin.applicants.show', $a) }}" class="inline-flex items-center gap-1 rounded-lg px-3 py-1.5 text-xs font-semibold text-indigo-600 transition-all hover:bg-indigo-50">
                                    Detail
                                    <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">{{ $applications->links() }}</div>
@endsection
