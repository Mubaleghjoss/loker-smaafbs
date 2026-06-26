@extends('layouts.app')

@section('content')
    <div class="flex min-h-[70vh] items-center justify-center">
        <div class="relative w-full max-w-md">
            {{-- Background blobs --}}
            <div class="absolute -left-20 -top-20 h-48 w-48 rounded-full bg-indigo-200/40 blur-3xl animate-blob"></div>
            <div class="absolute -bottom-16 -right-16 h-40 w-40 rounded-full bg-violet-200/40 blur-3xl animate-blob" style="animation-delay:2s"></div>

            <div class="relative card-glass p-8 animate-scale-in">
                <div class="text-center">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-brand-gradient shadow-brand">
                        <svg class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    <h1 class="mt-4 font-display text-2xl font-bold text-slate-900">Login Admin / Panitia</h1>
                    <p class="mt-1 text-sm text-slate-500">Masuk untuk mengelola lowongan dan pelamar</p>
                </div>

                <form method="post" action="{{ route('admin.login.submit') }}" class="mt-8 space-y-5">
                    @csrf

                    <div>
                        <label class="text-sm font-medium text-slate-700">Email</label>
                        <div class="relative mt-1.5">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5">
                                <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <input type="email" name="email" required value="{{ old('email') }}" placeholder="admin@afbs.local" class="input-modern !pl-10" />
                        </div>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-slate-700">Password</label>
                        <div class="relative mt-1.5">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5">
                                <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            </div>
                            <input type="password" name="password" required placeholder="••••••••" class="input-modern !pl-10" />
                        </div>
                    </div>

                    <button class="btn-primary w-full py-3 text-center">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                        Masuk Panel
                    </button>
                </form>

                <div class="mt-5 text-center text-xs text-slate-400">
                    <svg class="inline h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    Rate limit login aktif (5 percobaan / menit)
                </div>
            </div>
        </div>
    </div>
@endsection
