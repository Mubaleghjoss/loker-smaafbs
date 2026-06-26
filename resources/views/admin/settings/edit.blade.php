@extends('layouts.admin')

@section('content')
    <div class="animate-fade-in-up">
        <h1 class="font-display text-2xl font-bold text-slate-900">Pengaturan</h1>
        <p class="mt-1 text-sm text-slate-500">Konfigurasi umum dan tampilan website</p>
    </div>

    <div class="mt-5 grid gap-5 max-w-2xl">
        {{-- ═══════════════════════════════════════ --}}
        {{-- PENGATURAN UMUM --}}
        {{-- ═══════════════════════════════════════ --}}
        <div class="card p-6 animate-fade-in-up delay-1">
            <h2 class="flex items-center gap-2 font-display text-lg font-bold text-slate-900">
                <svg style="width:20px;height:20px;" class="text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Pengaturan Umum
            </h2>
            <form method="post" action="{{ route('admin.settings.update') }}" class="mt-4 space-y-5">
                @csrf
                <div>
                    <label class="text-sm font-medium text-slate-700">No. WhatsApp Admin</label>
                    <div class="relative mt-1.5">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5">
                            <svg style="width:16px;height:16px;" class="text-emerald-500" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/></svg>
                        </div>
                        <input name="admin_whatsapp" value="{{ old('admin_whatsapp', $admin_whatsapp) }}" placeholder="+628xxxxxxxxxx" class="input-modern !pl-10" required />
                    </div>
                    <div class="mt-1 text-xs text-slate-400">Untuk redirect WhatsApp setelah pelamar submit.</div>
                </div>
                <div class="flex items-center gap-3 rounded-xl border border-slate-100 bg-slate-50 p-4">
                    <input type="checkbox" name="mail_confirm_enabled" value="1" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500" @checked(old('mail_confirm_enabled', $mail_confirm_enabled)) />
                    <div>
                        <div class="text-sm font-medium text-slate-700">Aktifkan email konfirmasi</div>
                        <div class="text-xs text-slate-400">Kirim email konfirmasi via SMTP ke pelamar</div>
                    </div>
                </div>
                <div class="pt-2 border-t border-slate-100">
                    <button class="btn-primary">
                        <svg style="width:16px;height:16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>

        {{-- ═══════════════════════════════════════ --}}
        {{-- TAMPILAN & BRANDING --}}
        {{-- ═══════════════════════════════════════ --}}
        <div class="card p-6 animate-fade-in-up delay-2">
            <h2 class="flex items-center gap-2 font-display text-lg font-bold text-slate-900">
                <svg style="width:20px;height:20px;" class="text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/></svg>
                Tampilan & Branding
            </h2>
            <form method="post" action="{{ route('admin.settings.branding') }}" enctype="multipart/form-data" class="mt-4 space-y-5">
                @csrf

                {{-- Site Name & Description --}}
                <div>
                    <label class="text-sm font-medium text-slate-700">Nama Website</label>
                    <input name="site_name" value="{{ old('site_name', $site_name) }}" placeholder="Rekrutmen Guru SMA AFBS" class="input-modern mt-1.5" />
                    <div class="mt-1 text-xs text-slate-400">Tampil di judul tab browser dan preview WhatsApp.</div>
                </div>
                <div>
                    <label class="text-sm font-medium text-slate-700">Deskripsi Website</label>
                    <textarea name="site_description" rows="2" class="input-modern mt-1.5" placeholder="Sistem rekrutmen guru dan staf...">{{ old('site_description', $site_description) }}</textarea>
                    <div class="mt-1 text-xs text-slate-400">Tampil di mesin pencari dan preview link WhatsApp/Telegram.</div>
                </div>

                {{-- Navbar & Hero Text --}}
                <div class="rounded-xl border border-slate-100 bg-slate-50 p-5">
                    <div class="text-sm font-semibold text-slate-800">Teks Navbar & Halaman Depan</div>
                    <div class="mt-1 text-xs text-slate-500">Mengatur teks yang tampil di navbar dan hero section landing page.</div>
                    <div class="mt-4 grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="text-sm font-medium text-slate-700">Judul Navbar</label>
                            <input name="navbar_title" value="{{ old('navbar_title', $navbar_title) }}" placeholder="Rekrutmen Guru" class="input-modern mt-1.5" />
                        </div>
                        <div>
                            <label class="text-sm font-medium text-slate-700">Subjudul Navbar</label>
                            <input name="navbar_subtitle" value="{{ old('navbar_subtitle', $navbar_subtitle) }}" placeholder="SMA AFBS" class="input-modern mt-1.5" />
                        </div>
                    </div>
                    <div class="mt-4">
                        <label class="text-sm font-medium text-slate-700">Judul Hero (Landing Page)</label>
                        <input name="hero_title" value="{{ old('hero_title', $hero_title) }}" placeholder="Rekrutmen Guru\nSMA AFBS" class="input-modern mt-1.5" />
                        <div class="mt-1 text-xs text-slate-400">Gunakan \n untuk baris baru. Contoh: Rekrutmen Guru\nSMA AFBS</div>
                    </div>
                    <div class="mt-4">
                        <label class="text-sm font-medium text-slate-700">Deskripsi Hero</label>
                        <textarea name="hero_description" rows="2" class="input-modern mt-1.5" placeholder="Bergabunglah bersama kami...">{{ old('hero_description', $hero_description) }}</textarea>
                    </div>
                </div>

                {{-- Brand Colors --}}
                <div class="rounded-xl border border-slate-100 bg-slate-50 p-5">
                    <div class="text-sm font-semibold text-slate-800">Warna Brand</div>
                    <div class="mt-1 text-xs text-slate-500">Warna utama dipakai untuk tombol, gradient, dan aksen di seluruh website.</div>
                    <div class="mt-4 grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="text-sm font-medium text-slate-700">Warna Utama</label>
                            <div class="mt-1.5 flex items-center gap-3">
                                <input type="color" name="brand_color" value="{{ old('brand_color', $brand_color) }}" class="h-10 w-14 cursor-pointer rounded-lg border border-slate-200" />
                                <input type="text" value="{{ old('brand_color', $brand_color) }}" class="input-modern flex-1 font-mono text-sm" readonly onclick="this.select()" />
                            </div>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-slate-700">Warna Sekunder</label>
                            <div class="mt-1.5 flex items-center gap-3">
                                <input type="color" name="brand_color_secondary" value="{{ old('brand_color_secondary', $brand_color_secondary) }}" class="h-10 w-14 cursor-pointer rounded-lg border border-slate-200" />
                                <input type="text" value="{{ old('brand_color_secondary', $brand_color_secondary) }}" class="input-modern flex-1 font-mono text-sm" readonly onclick="this.select()" />
                            </div>
                        </div>
                    </div>
                    {{-- Preview --}}
                    <div class="mt-4">
                        <div class="text-xs font-medium text-slate-500 mb-2">Preview gradient:</div>
                        <div class="h-10 rounded-xl" style="background: linear-gradient(135deg, {{ $brand_color }}, {{ $brand_color_secondary }});"></div>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="text-sm font-medium text-slate-700">Teks Footer</label>
                        <input name="footer_text" value="{{ old('footer_text', $footer_text) }}" class="input-modern mt-1.5" placeholder="© 2026 SMA AFBS — Sistem Rekrutmen" />
                        <div class="mt-1 text-xs text-slate-400">Tampil di bagian bawah kiri halaman publik.</div>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-700">Powered By</label>
                        <input name="powered_by" value="{{ old('powered_by', $powered_by) }}" class="input-modern mt-1.5" placeholder="Powered by Laravel" />
                        <div class="mt-1 text-xs text-slate-400">Tampil di bagian bawah kanan halaman publik.</div>
                    </div>
                </div>

                {{-- Favicon Upload --}}
                <div class="rounded-xl border border-slate-100 bg-slate-50 p-5">
                    <div class="text-sm font-semibold text-slate-800">Favicon</div>
                    <div class="mt-1 text-xs text-slate-500">Icon kecil yang muncul di tab browser. Rekomendasi ukuran 512×512 px, format PNG.</div>
                    <div class="mt-3 flex items-center gap-4">
                        @if ($current_favicon)
                            <img src="{{ asset($current_favicon) }}?t={{ time() }}" alt="Favicon" class="h-12 w-12 rounded-lg border border-slate-200 bg-white object-contain p-1">
                        @else
                            <div class="flex h-12 w-12 items-center justify-center rounded-lg border-2 border-dashed border-slate-200 bg-white text-slate-300">
                                <svg style="width:20px;height:20px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                        @endif
                        <div class="flex-1">
                            <input type="file" name="favicon" accept="image/png,image/jpeg,image/x-icon,image/svg+xml" class="w-full text-sm file:mr-3 file:rounded-lg file:border-0 file:bg-indigo-50 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-indigo-700 hover:file:bg-indigo-100" />
                            <div class="mt-1 text-xs text-slate-400">PNG, JPG, ICO, atau SVG. Maks 2MB.</div>
                        </div>
                    </div>
                </div>

                {{-- OG Image Upload --}}
                <div class="rounded-xl border border-slate-100 bg-slate-50 p-5">
                    <div class="text-sm font-semibold text-slate-800">Gambar Preview Link (OG Image)</div>
                    <div class="mt-1 text-xs text-slate-500">Gambar yang muncul saat link website dikirim ke WhatsApp/Telegram. Rekomendasi 1200×630 px.</div>
                    <div class="mt-3">
                        @if ($current_og_image)
                            <img src="{{ asset($current_og_image) }}?t={{ time() }}" alt="OG Image" class="mb-3 h-32 w-full rounded-lg border border-slate-200 bg-white object-cover">
                        @endif
                        <input type="file" name="og_image" accept="image/png,image/jpeg" class="w-full text-sm file:mr-3 file:rounded-lg file:border-0 file:bg-indigo-50 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-indigo-700 hover:file:bg-indigo-100" />
                        <div class="mt-1 text-xs text-slate-400">PNG atau JPG. Maks 5MB.</div>
                    </div>
                </div>

                <div class="pt-2 border-t border-slate-100">
                    <button class="btn-primary">
                        <svg style="width:16px;height:16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        Simpan Tampilan
                    </button>
                </div>
            </form>
        </div>

        {{-- ═══════════════════════════════════════ --}}
        {{-- BACKUP & EXPORT --}}
        {{-- ═══════════════════════════════════════ --}}
        <div class="card p-6 animate-fade-in-up delay-3">
            <h2 class="flex items-center gap-2 font-display text-lg font-bold text-slate-900">
                <svg style="width:20px;height:20px;" class="text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/></svg>
                Backup & Export Database
            </h2>
            <p class="mt-1 text-sm text-slate-500">Download backup atau export data untuk migrasi ke server.</p>
            <div class="mt-5 space-y-3">
                <div class="flex items-center justify-between rounded-xl border border-slate-100 bg-white p-4 hover:border-indigo-200 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="flex items-center justify-center rounded-lg bg-blue-50 text-blue-600" style="width:40px;height:40px;">
                            <svg style="width:20px;height:20px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        </div>
                        <div>
                            <div class="text-sm font-semibold text-slate-900">Download File SQLite</div>
                            <div class="text-xs text-slate-400">Backup lengkap file database</div>
                        </div>
                    </div>
                    <a href="{{ route('admin.backup.sqlite') }}" class="btn-secondary text-xs">Download .sqlite</a>
                </div>
                <div class="flex items-center justify-between rounded-xl border border-slate-100 bg-white p-4 hover:border-indigo-200 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="flex items-center justify-center rounded-lg bg-emerald-50 text-emerald-600" style="width:40px;height:40px;">
                            <svg style="width:20px;height:20px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                        </div>
                        <div>
                            <div class="text-sm font-semibold text-slate-900">Export ke MySQL SQL</div>
                            <div class="text-xs text-slate-400">Import ke phpMyAdmin server</div>
                        </div>
                    </div>
                    <a href="{{ route('admin.backup.mysql') }}" class="btn-primary text-xs">Export .sql</a>
                </div>
            </div>
            <div class="mt-4 rounded-xl border border-amber-100 bg-gradient-to-r from-amber-50 to-yellow-50 p-4">
                <div class="flex items-start gap-2">
                    <svg style="width:16px;height:16px;margin-top:2px;flex-shrink:0;" class="text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <div class="text-xs text-amber-800">
                        <strong>Migrasi:</strong> Export .sql → phpMyAdmin (Import) → Pastikan .env server pakai DB_CONNECTION=mysql
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Sync color picker with text input
        document.querySelectorAll('input[type="color"]').forEach(function(picker) {
            var textInput = picker.parentElement.querySelector('input[type="text"]');
            if (textInput) {
                picker.addEventListener('input', function() {
                    textInput.value = this.value;
                    // Update gradient preview
                    var c1 = document.querySelector('[name="brand_color"]').value;
                    var c2 = document.querySelector('[name="brand_color_secondary"]').value;
                    var preview = document.querySelector('[style*="linear-gradient"]');
                    if (preview) preview.style.background = 'linear-gradient(135deg, ' + c1 + ', ' + c2 + ')';
                });
            }
        });
    </script>
@endsection
