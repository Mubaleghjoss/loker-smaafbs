@extends('layouts.app')

@section('content')
    <div class="animate-fade-in-up card p-6 sm:p-8">
        <div class="flex flex-wrap items-end justify-between gap-3">
            <div>
                <h1 class="font-display text-2xl font-bold text-slate-900">Form Pendaftaran</h1>
                <p class="mt-1 text-sm text-slate-500">Lengkapi data dengan benar. Berkas wajib sesuai format.</p>
            </div>
            <a href="{{ route('status.form') }}" class="text-sm font-semibold text-brand hover:text-brand-secondary transition-colors flex items-center gap-1">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                Sudah daftar? Cek status
            </a>
        </div>

        @if (!empty($prefillPositionRequirements))
            @php($reqLines = array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $prefillPositionRequirements) ?: []))))
            @if (count($reqLines))
                <div class="mt-6 rounded-xl border p-5 animate-fade-in-up delay-1 border-brand-light bg-brand-lighter">
                    <div class="flex items-center gap-2 text-sm font-semibold text-brand">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        Persyaratan untuk posisi: {{ $prefillPositionTitle }}
                    </div>
                    <ul class="mt-3 list-disc space-y-1 pl-5 text-sm" style="color: var(--brand-primary)">
                        @foreach ($reqLines as $line)
                            <li>{{ $line }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        @endif

        <form class="mt-8 space-y-6" method="post" action="{{ route('applications.store') }}" enctype="multipart/form-data">
            @csrf

            {{-- Section: Posisi --}}
            <div class="animate-fade-in-up delay-1">
                <div class="flex items-center gap-2 mb-4">
                    <div class="flex h-7 w-7 items-center justify-center rounded-lg bg-brand-gradient text-xs font-bold text-white">1</div>
                    <h3 class="font-display font-semibold text-slate-800">Posisi yang Dilamar</h3>
                </div>
                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="text-sm font-medium text-slate-700">Pilih posisi</label>
                        <select name="position_id" class="input-modern mt-1.5">
                            <option value="">-- Pilih posisi --</option>
                            @foreach ($positions as $pos)
                                <option value="{{ $pos->id }}" @selected(old('position_id', $prefillPositionId) == $pos->id)>{{ $pos->name }}</option>
                            @endforeach
                        </select>
                        <div class="mt-1 text-xs text-slate-400">Jika posisi tidak ada, isi kolom manual.</div>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-700">Posisi manual</label>
                        <input name="position_title" value="{{ old('position_title', $prefillPositionTitle) }}" placeholder="Contoh: Staf Perpustakaan" class="input-modern mt-1.5" />
                    </div>
                </div>
            </div>

            <hr class="border-slate-100">

            {{-- Section: Data Diri --}}
            <div class="animate-fade-in-up delay-2">
                <div class="flex items-center gap-2 mb-4">
                    <div class="flex h-7 w-7 items-center justify-center rounded-lg bg-brand-gradient text-xs font-bold text-white">2</div>
                    <h3 class="font-display font-semibold text-slate-800">Data Diri</h3>
                </div>
                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="text-sm font-medium text-slate-700">Nama lengkap <span class="text-rose-400">*</span></label>
                        <input required name="full_name" value="{{ old('full_name') }}" class="input-modern mt-1.5" />
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-700">Email (opsional)</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="input-modern mt-1.5" />
                    </div>
                </div>
                <div class="mt-4 grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="text-sm font-medium text-slate-700">Tempat lahir <span class="text-rose-400">*</span></label>
                        <input required name="birth_place" value="{{ old('birth_place') }}" class="input-modern mt-1.5" />
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-700">Tanggal lahir <span class="text-rose-400">*</span></label>
                        <input required type="date" name="birth_date" value="{{ old('birth_date') }}" class="input-modern mt-1.5" />
                    </div>
                </div>
                <div class="mt-4 grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="text-sm font-medium text-slate-700">No. WhatsApp <span class="text-rose-400">*</span></label>
                        <input required name="whatsapp" value="{{ old('whatsapp') }}" placeholder="08xxxxxxxxxx" class="input-modern mt-1.5" />
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-700">Domisili <span class="text-rose-400">*</span></label>
                        <input required name="domicile" value="{{ old('domicile') }}" placeholder="Kab. X / Kota Y" class="input-modern mt-1.5" />
                    </div>
                </div>
                <div class="mt-4">
                    <label class="text-sm font-medium text-slate-700">Alamat <span class="text-rose-400">*</span></label>
                    <textarea required name="address" rows="3" class="input-modern mt-1.5">{{ old('address') }}</textarea>
                </div>
                <div class="mt-4">
                    <label class="text-sm font-medium text-slate-700">Alamat Sambung <span class="text-rose-400">*</span></label>
                    <input required name="connected_address" value="{{ old('connected_address') }}" placeholder="Nama Kelompok, Nama Desa dan Daerah" class="input-modern mt-1.5" />
                </div>
            </div>

            <hr class="border-slate-100">

            {{-- Section: Pendidikan --}}
            <div class="animate-fade-in-up delay-3">
                <div class="flex items-center gap-2 mb-4">
                    <div class="flex h-7 w-7 items-center justify-center rounded-lg bg-brand-gradient text-xs font-bold text-white">3</div>
                    <h3 class="font-display font-semibold text-slate-800">Pendidikan</h3>
                </div>
                <div class="rounded-xl border border-slate-100 bg-slate-50/50 p-5">
                    <div class="grid gap-4 md:grid-cols-3">
                        <div>
                            <label class="text-sm font-medium text-slate-700">Pendidikan terakhir <span class="text-rose-400">*</span></label>
                            <select required name="last_education" class="input-modern mt-1.5">
                                <option value="">-- Pilih --</option>
                                @foreach (['SMA/SMK','D3','S1','S2','S3'] as $edu)
                                    <option value="{{ $edu }}" @selected(old('last_education') === $edu)>{{ $edu }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-slate-700">Jurusan <span class="text-rose-400">*</span></label>
                            <input required name="major" value="{{ old('major') }}" class="input-modern mt-1.5" />
                        </div>
                        <div>
                            <label class="text-sm font-medium text-slate-700">Nama Sekolah / Kampus <span class="text-rose-400">*</span></label>
                            <input required name="campus" value="{{ old('campus') }}" class="input-modern mt-1.5" />
                        </div>
                    </div>
                </div>
            </div>

            <hr class="border-slate-100">

            {{-- Section: Berkas --}}
            <div class="animate-fade-in-up delay-4">
                <div class="flex items-center gap-2 mb-4">
                    <div class="flex h-7 w-7 items-center justify-center rounded-lg bg-brand-gradient text-xs font-bold text-white">4</div>
                    <h3 class="font-display font-semibold text-slate-800">Upload Berkas</h3>
                </div>
                <div class="grid gap-4 md:grid-cols-2">
                    <div class="rounded-xl border-2 border-dashed border-slate-200 bg-slate-50/50 p-5 text-center hover:border-brand-light hover:bg-brand-lighter transition-colors">
                        <svg class="mx-auto h-8 w-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                        <div class="mt-2 text-sm font-semibold text-slate-700">CV (PDF)</div>
                        <div class="text-xs text-slate-400">Maks 3MB</div>
                        <input required type="file" name="cv" accept="application/pdf" class="mt-3 w-full text-sm file:mr-3 file:rounded-lg file:border-0 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:border-0 file:rounded-lg file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200" />
                    </div>
                    <div class="rounded-xl border-2 border-dashed border-slate-200 bg-slate-50/50 p-5 text-center hover:border-brand-light hover:bg-brand-lighter transition-colors">
                        <svg class="mx-auto h-8 w-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z"/></svg>
                        <div class="mt-2 text-sm font-semibold text-slate-700">Ijazah (PDF/JPG/PNG)</div>
                        <div class="text-xs text-slate-400">Maks 4MB</div>
                        <input required type="file" name="diploma" accept="application/pdf,image/jpeg,image/png" class="mt-3 w-full text-sm file:mr-3 file:rounded-lg file:border-0 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:border-0 file:rounded-lg file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200" />
                    </div>
                </div>
            </div>

            <hr class="border-slate-100">

            {{-- Gaji --}}
            <div class="animate-fade-in-up delay-5">
                <label class="text-sm font-medium text-slate-700">Harapan upah (Rp) <span class="text-slate-400">(opsional)</span></label>
                <input type="number" name="expected_salary" value="{{ old('expected_salary') }}" min="0" step="10000" placeholder="Contoh: 3500000" class="input-modern mt-1.5 max-w-sm" />
            </div>

            {{-- Submit --}}
            <div class="flex flex-wrap items-center justify-between gap-4 pt-2 border-t border-slate-100">
                <p class="text-xs text-slate-400">Dengan mengirim form ini, Anda menyatakan data yang diisi benar.</p>
                <button type="submit" class="btn-primary px-6 py-3">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    Kirim Pendaftaran
                </button>
            </div>
        </form>
    </div>
@endsection
