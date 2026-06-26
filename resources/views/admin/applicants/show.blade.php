@extends('layouts.admin')

@section('content')
    @php($status = $application->statusEnum())

    {{-- Header --}}
    <div class="flex flex-wrap items-start justify-between gap-4 animate-fade-in-up">
        <div class="flex items-center gap-4">
            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-indigo-400 to-violet-500 text-lg font-bold text-white shadow-brand">
                {{ strtoupper(substr($application->full_name, 0, 2)) }}
            </div>
            <div>
                <h1 class="font-display text-2xl font-bold text-slate-900">{{ $application->full_name }}</h1>
                <div class="mt-1 flex items-center gap-2">
                    <span class="rounded-md bg-slate-100 px-2 py-0.5 font-mono text-xs font-medium text-slate-600">{{ $application->registration_code }}</span>
                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-bold ring-1 {{ $status->badgeClasses() }}">{{ $status->label() }}</span>
                </div>
            </div>
        </div>
        <a href="{{ route('admin.applicants.index') }}" class="btn-secondary">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </a>
    </div>

    <div class="mt-6 grid gap-6 lg:grid-cols-2">
        <div class="space-y-5">
            {{-- Info Pribadi --}}
            <div class="card p-6 animate-fade-in-up delay-1">
                <h2 class="flex items-center gap-2 font-display text-lg font-bold text-slate-900">
                    <svg class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Data Pribadi
                </h2>
                <div class="mt-4 grid gap-3 sm:grid-cols-2">
                    <div class="rounded-lg bg-slate-50 p-3">
                        <div class="text-xs font-medium text-slate-400 uppercase tracking-wider">Nama</div>
                        <div class="mt-1 font-semibold text-slate-900">{{ $application->full_name }}</div>
                    </div>
                    <div class="rounded-lg bg-slate-50 p-3">
                        <div class="text-xs font-medium text-slate-400 uppercase tracking-wider">Posisi</div>
                        <div class="mt-1 font-semibold text-slate-900">{{ $application->position_title }}</div>
                    </div>
                    <div class="rounded-lg bg-slate-50 p-3">
                        <div class="text-xs font-medium text-slate-400 uppercase tracking-wider">WhatsApp</div>
                        <div class="mt-1 font-semibold text-slate-900">{{ $application->whatsapp }}</div>
                    </div>
                    <div class="rounded-lg bg-slate-50 p-3">
                        <div class="text-xs font-medium text-slate-400 uppercase tracking-wider">Domisili</div>
                        <div class="mt-1 font-semibold text-slate-900">{{ $application->domicile }}</div>
                    </div>
                    @if ($application->email)
                        <div class="rounded-lg bg-slate-50 p-3 sm:col-span-2">
                            <div class="text-xs font-medium text-slate-400 uppercase tracking-wider">Email</div>
                            <div class="mt-1 font-semibold text-slate-900">{{ $application->email }}</div>
                        </div>
                    @endif
                </div>
                <div class="mt-3 rounded-lg bg-slate-50 p-3">
                    <div class="text-xs font-medium text-slate-400 uppercase tracking-wider">Alamat</div>
                    <div class="mt-1 text-sm text-slate-700 whitespace-pre-line">{{ $application->address }}</div>
                </div>
                <div class="mt-3 rounded-lg bg-slate-50 p-3">
                    <div class="text-xs font-medium text-slate-400 uppercase tracking-wider">Alamat Sambung</div>
                    <div class="mt-1 text-sm text-slate-700">{{ $application->connected_address }}</div>
                </div>
                <div class="mt-3 text-xs text-slate-400">Submit: {{ optional($application->submitted_at)->format('d/m/Y H:i') }}</div>
            </div>

            {{-- Berkas --}}
            <div class="card p-6 animate-fade-in-up delay-2">
                <h2 class="flex items-center gap-2 font-display text-lg font-bold text-slate-900">
                    <svg class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Berkas
                </h2>
                <div class="mt-4 grid gap-3 sm:grid-cols-2">
                    <div class="flex items-center gap-3 rounded-xl border border-slate-100 p-4 hover:border-indigo-200 transition-colors">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-rose-50 text-rose-600">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-semibold text-slate-900">CV</div>
                            <div class="flex gap-2 mt-1">
                                <a href="{{ route('admin.applicants.preview', [$application, 'cv']) }}" target="_blank" class="text-xs font-medium text-indigo-600 hover:text-indigo-700">Preview</a>
                                <a href="{{ route('admin.applicants.files', [$application, 'cv']) }}" class="text-xs font-medium text-indigo-600 hover:text-indigo-700">Download</a>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 rounded-xl border border-slate-100 p-4 hover:border-indigo-200 transition-colors">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-semibold text-slate-900">Ijazah</div>
                            <div class="flex gap-2 mt-1">
                                <a href="{{ route('admin.applicants.preview', [$application, 'diploma']) }}" target="_blank" class="text-xs font-medium text-indigo-600 hover:text-indigo-700">Preview</a>
                                <a href="{{ route('admin.applicants.files', [$application, 'diploma']) }}" class="text-xs font-medium text-indigo-600 hover:text-indigo-700">Download</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-5">
            {{-- Pendidikan --}}
            <div class="card p-6 animate-fade-in-up delay-3">
                <h2 class="flex items-center gap-2 font-display text-lg font-bold text-slate-900">
                    <svg class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M12 14l9-5-9-5-9 5 9 5z"/><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                    Pendidikan
                </h2>
                <div class="mt-4 grid gap-3 sm:grid-cols-2">
                    <div class="rounded-lg bg-slate-50 p-3">
                        <div class="text-xs font-medium text-slate-400 uppercase tracking-wider">Pendidikan</div>
                        <div class="mt-1 font-semibold text-slate-900">{{ $application->last_education }}</div>
                    </div>
                    <div class="rounded-lg bg-slate-50 p-3">
                        <div class="text-xs font-medium text-slate-400 uppercase tracking-wider">Jurusan</div>
                        <div class="mt-1 font-semibold text-slate-900">{{ $application->major }}</div>
                    </div>
                    <div class="rounded-lg bg-slate-50 p-3 sm:col-span-2">
                        <div class="text-xs font-medium text-slate-400 uppercase tracking-wider">Kampus</div>
                        <div class="mt-1 font-semibold text-slate-900">{{ $application->campus }}</div>
                    </div>
                </div>
            </div>

            {{-- Update Status --}}
            <div class="card p-6 animate-fade-in-up delay-4">
                <h2 class="flex items-center gap-2 font-display text-lg font-bold text-slate-900">
                    <svg class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Update Status
                </h2>
                <form method="post" action="{{ route('admin.applicants.status', $application) }}" class="mt-4 space-y-4">
                    @csrf
                    <div>
                        <label class="text-sm font-medium text-slate-700">Status</label>
                        <select name="status" class="input-modern mt-1.5" required>
                            @foreach ($statuses as $s)
                                <option value="{{ $s->value }}" @selected(old('status', $application->status) === $s->value)>{{ $s->label() }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-700">Catatan ke pelamar <span class="text-slate-400">(opsional)</span></label>
                        <textarea name="public_note" rows="3" class="input-modern mt-1.5" placeholder="Contoh: Mohon upload ijazah yang lebih jelas">{{ old('public_note', $application->public_note) }}</textarea>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-700">Catatan internal <span class="text-slate-400">(opsional)</span></label>
                        <textarea name="internal_note" rows="3" class="input-modern mt-1.5" placeholder="Catatan internal, tidak terlihat pelamar">{{ old('internal_note', $application->internal_note) }}</textarea>
                    </div>
                    <button class="btn-primary">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
