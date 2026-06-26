@extends('layouts.admin')

@section('content')
    <div class="animate-fade-in-up">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.admin-users.index') }}" class="flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 text-slate-400 hover:bg-slate-50 transition-colors">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h1 class="font-display text-2xl font-bold text-slate-900">Tambah Admin/Panitia</h1>
        </div>
    </div>

    <div class="mt-5 card p-6 max-w-2xl animate-fade-in-up delay-1">
        <form method="post" action="{{ route('admin.admin-users.store') }}" class="space-y-5">
            @csrf
            <div>
                <label class="text-sm font-medium text-slate-700">Nama <span class="text-rose-400">*</span></label>
                <input name="name" required value="{{ old('name') }}" class="input-modern mt-1.5" />
            </div>
            <div>
                <label class="text-sm font-medium text-slate-700">Email <span class="text-rose-400">*</span></label>
                <input type="email" name="email" required value="{{ old('email') }}" class="input-modern mt-1.5" />
            </div>
            <div>
                <label class="text-sm font-medium text-slate-700">Password <span class="text-rose-400">*</span></label>
                <input type="password" name="password" required class="input-modern mt-1.5" />
                <div class="mt-1 text-xs text-slate-400">Minimal 10 karakter.</div>
            </div>
            <div class="flex items-center gap-3 rounded-xl border border-amber-100 bg-gradient-to-r from-amber-50 to-orange-50 p-4">
                <input type="checkbox" name="is_super" value="1" class="rounded border-slate-300 text-amber-600 focus:ring-amber-500" @checked(old('is_super')) />
                <div>
                    <div class="text-sm font-medium text-amber-800">Jadikan Super Admin</div>
                    <div class="text-xs text-amber-600">Mendapat semua akses otomatis tanpa batasan</div>
                </div>
            </div>
            <div class="rounded-xl border border-slate-100 bg-slate-50 p-5">
                <div class="text-sm font-semibold text-slate-800">Akses Menu (Permission)</div>
                <div class="mt-1 text-xs text-slate-500">Untuk panitia lowongan, centang Kelola Lowongan/Posisi. Jika super admin dicentang, semua akses otomatis terbuka.</div>
                <div class="mt-4 grid gap-2">
                    @foreach ($permissions as $key => $label)
                        <label class="flex items-center gap-2 hover:bg-white p-1.5 rounded-lg transition-colors cursor-pointer">
                            <input type="checkbox" name="permissions[]" value="{{ $key }}" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500"
                                   @checked(is_array(old('permissions')) && in_array($key, old('permissions'), true)) />
                            <span class="text-sm text-slate-700">{{ $label }}</span>
                            <span class="rounded bg-slate-200 px-1.5 py-0.5 text-[10px] font-mono text-slate-500">{{ $key }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
            <div class="flex gap-2 pt-2 border-t border-slate-100">
                <a href="{{ route('admin.admin-users.index') }}" class="btn-secondary">Batal</a>
                <button class="btn-primary">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    Simpan
                </button>
            </div>
        </form>
    </div>
@endsection
