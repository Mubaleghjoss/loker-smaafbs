@extends('layouts.admin')

@section('content')
    <div class="flex flex-wrap items-end justify-between gap-4 animate-fade-in-up">
        <div>
            <h1 class="font-display text-2xl font-bold text-slate-900">Lowongan</h1>
            <p class="mt-1 text-sm text-slate-500">Tambah, update, aktifkan, atau nonaktifkan lowongan yang tampil untuk pelamar.</p>
        </div>
        <a href="{{ route('admin.positions.create') }}" class="btn-primary">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Tambah Lowongan
        </a>
    </div>

    <div class="mt-5 card overflow-hidden animate-fade-in-up delay-1">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/50">
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Nama</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Slug</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Pelamar</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Status</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Urut</th>
                        <th class="px-5 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach ($positions as $p)
                        <tr class="table-row-hover transition-colors">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    </div>
                                    <span class="font-medium text-slate-900">{{ $p->name }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-3.5"><span class="rounded-md bg-slate-100 px-2 py-0.5 font-mono text-xs text-slate-600">{{ $p->slug }}</span></td>
                            <td class="px-5 py-3.5">
                                @if ($p->applications_count > 0)
                                    <a href="{{ route('admin.applicants.index', ['position' => $p->name]) }}" class="inline-flex items-center gap-1.5 rounded-full bg-indigo-50 px-3 py-1 text-xs font-bold text-indigo-700 hover:bg-indigo-100 transition-colors">
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        {{ $p->applications_count }} pelamar
                                    </a>
                                @else
                                    <span class="text-xs text-slate-500">0 pelamar</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5">
                                <form method="post" action="{{ route('admin.positions.toggle', $p) }}" class="inline">
                                    @csrf
                                    @if ($p->is_active)
                                        <button type="submit" class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-700 hover:bg-emerald-100 transition-colors ring-1 ring-emerald-200" title="Klik untuk nonaktifkan">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                            Aktif
                                        </button>
                                    @else
                                        <button type="submit" class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-500 hover:bg-slate-200 transition-colors ring-1 ring-slate-200" title="Klik untuk aktifkan">
                                            <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                                            Nonaktif
                                        </button>
                                    @endif
                                </form>
                            </td>
                            <td class="px-5 py-3.5 text-sm text-slate-500">{{ $p->sort_order }}</td>
                            <td class="px-5 py-3.5 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('admin.positions.edit', $p) }}" class="rounded-lg px-3 py-1.5 text-xs font-semibold text-indigo-700 hover:bg-indigo-50 transition-colors">Update Lowongan</a>
                                    <form class="inline" method="post" action="{{ route('admin.positions.destroy', $p) }}" onsubmit="return confirm('Hapus posisi ini?')">
                                        @csrf @method('DELETE')
                                        <button class="rounded-lg px-3 py-1.5 text-xs font-semibold text-rose-600 hover:bg-rose-50 transition-colors">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">{{ $positions->links() }}</div>
@endsection
