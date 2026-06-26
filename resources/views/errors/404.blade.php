@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-2xl">
        <div class="rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">
            <div class="inline-flex items-center rounded-full bg-rose-50 px-3 py-1 text-xs font-semibold text-rose-700 ring-1 ring-rose-200">
                404
            </div>

            <h1 class="mt-4 text-2xl font-extrabold tracking-tight">Halaman tidak ditemukan</h1>
            <p class="mt-2 text-slate-600">
                Maaf, halaman yang Anda cari tidak tersedia atau sudah dipindahkan.
            </p>

            <div class="mt-6 flex flex-wrap gap-2">
                <a href="{{ route('home') }}" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">
                    Kembali ke Beranda
                </a>
                <a href="{{ route('applications.create') }}" class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold hover:bg-slate-50">
                    Daftar Rekrutmen
                </a>
                <a href="{{ route('status.form') }}" class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold hover:bg-slate-50">
                    Cek Status
                </a>
            </div>

            <div class="mt-6 rounded-xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-700">
                Jika Anda yakin ini kesalahan sistem, silakan hubungi admin.
            </div>
        </div>
    </div>
@endsection
