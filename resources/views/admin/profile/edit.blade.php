@extends('layouts.admin')

@section('content')
    <div class="animate-fade-in-up">
        <h1 class="font-display text-2xl font-bold text-slate-900">Profil</h1>
        <p class="mt-1 text-sm text-slate-500">Ubah email dan password akun Anda</p>
    </div>

    <div class="mt-5 grid gap-5 max-w-2xl">
        {{-- Profile card --}}
        <div class="card p-6 animate-fade-in-up delay-1">
            <div class="flex items-center gap-4">
                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-indigo-400 to-violet-500 text-lg font-bold text-white shadow-brand">
                    {{ strtoupper(substr($adminUser->name, 0, 2)) }}
                </div>
                <div>
                    <div class="font-display text-lg font-bold text-slate-900">{{ $adminUser->name }}</div>
                    <div class="text-sm text-slate-500">{{ method_exists($adminUser, 'roleLabel') ? $adminUser->roleLabel() : ($adminUser->is_super ? 'Super Admin' : 'Panitia') }}</div>
                </div>
            </div>
        </div>

        {{-- Edit form --}}
        <div class="card p-6 animate-fade-in-up delay-2">
            <form method="post" action="{{ route('admin.profile.update') }}" class="space-y-5">
                @csrf
                <div>
                    <label class="text-sm font-medium text-slate-700">Nama</label>
                    <input disabled value="{{ $adminUser->name }}" class="input-modern mt-1.5 !bg-slate-50 !text-slate-500 cursor-not-allowed" />
                </div>
                <div>
                    <label class="text-sm font-medium text-slate-700">Email</label>
                    <input type="email" name="email" required value="{{ old('email', $adminUser->email) }}" class="input-modern mt-1.5" />
                </div>

                <div class="rounded-xl border border-slate-100 bg-slate-50 p-5">
                    <div class="text-sm font-semibold text-slate-800">Ganti Password <span class="text-slate-400">(opsional)</span></div>
                    <div class="mt-4 space-y-4">
                        <div>
                            <label class="text-sm font-medium text-slate-700">Password baru</label>
                            <input type="password" name="new_password" class="input-modern mt-1.5" placeholder="Minimal 10 karakter" />
                        </div>
                        <div>
                            <label class="text-sm font-medium text-slate-700">Konfirmasi password baru</label>
                            <input type="password" name="new_password_confirmation" class="input-modern mt-1.5" />
                        </div>
                    </div>
                </div>

                <div>
                    <label class="text-sm font-medium text-slate-700">Password saat ini <span class="text-rose-400">*</span></label>
                    <input type="password" name="current_password" required class="input-modern mt-1.5" />
                    <div class="mt-1 text-xs text-slate-400">Wajib diisi untuk keamanan saat menyimpan perubahan.</div>
                </div>

                <div class="pt-2 border-t border-slate-100">
                    <button class="btn-primary">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
