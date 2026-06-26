@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-2xl">
        <div class="rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">
            <div class="inline-flex items-center rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-800 ring-1 ring-amber-200">
                419
            </div>

            <h1 class="mt-4 text-2xl font-extrabold tracking-tight">Sesi berakhir</h1>
            <p class="mt-2 text-slate-600">
                Demi keamanan, sesi Anda sudah berakhir (atau token keamanan tidak valid).
                Silakan muat ulang halaman dan coba lagi.
            </p>

            <div class="mt-6 flex flex-wrap gap-2">
                <a href="{{ url()->current() }}" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">
                    Muat Ulang
                </a>
                <a href="{{ route('home') }}" class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold hover:bg-slate-50">
                    Kembali ke Beranda
                </a>
            </div>

            <div class="mt-6 rounded-xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-700">
                Tip: Jika Anda mengisi form cukup lama, sebaiknya submit ulang setelah refresh.
            </div>
        </div>
    </div>
@endsection
