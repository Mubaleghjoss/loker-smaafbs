@extends('layouts.admin')

@section('content')
    <div class="animate-fade-in-up">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.positions.index') }}" class="flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 text-slate-400 hover:bg-slate-50 transition-colors">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h1 class="font-display text-2xl font-bold text-slate-900">Tambah Lowongan</h1>
        </div>
    </div>

    <div class="mt-5 card p-6 max-w-2xl animate-fade-in-up delay-1">
        <form method="post" action="{{ route('admin.positions.store') }}" class="space-y-5">
            @csrf
            <div>
                <label class="text-sm font-medium text-slate-700">Nama <span class="text-rose-400">*</span></label>
                <input name="name" value="{{ old('name') }}" required class="input-modern mt-1.5" />
            </div>
            <div>
                <label class="text-sm font-medium text-slate-700">Slug <span class="text-slate-400">(opsional)</span></label>
                <input name="slug" value="{{ old('slug') }}" placeholder="otomatis dari nama" class="input-modern mt-1.5" />
            </div>
            <div>
                <label class="text-sm font-medium text-slate-700">Deskripsi <span class="text-slate-400">(opsional)</span></label>
                <textarea name="description" rows="3" class="input-modern mt-1.5">{{ old('description') }}</textarea>
            </div>
            <div>
                <label class="text-sm font-medium text-slate-700">Persyaratan melamar <span class="text-slate-400">(opsional)</span></label>
                <textarea name="requirements" rows="5" placeholder="Tulis per baris, contoh:&#10;Minimal S1 sesuai mapel&#10;Siap mengajar full time" class="input-modern mt-1.5">{{ old('requirements') }}</textarea>
                <div class="mt-1 text-xs text-slate-400">Tulis per baris agar tampil sebagai daftar di landing.</div>
            </div>
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="text-sm font-medium text-slate-700">Urutan</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" class="input-modern mt-1.5" />
                </div>
                <div class="flex items-center gap-2 pt-7">
                    <input type="checkbox" name="is_active" value="1" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500" checked />
                    <span class="text-sm font-medium text-slate-700">Aktif</span>
                </div>
            </div>
            <div class="flex gap-2 pt-2 border-t border-slate-100">
                <a href="{{ route('admin.positions.index') }}" class="btn-secondary">Batal</a>
                <button class="btn-primary">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    Simpan Lowongan
                </button>
            </div>
        </form>
    </div>
@endsection
