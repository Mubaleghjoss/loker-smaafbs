<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? \App\Models\Setting::getValue('site_name', 'Rekrutmen Guru SMA AFBS') }}</title>
    @include('partials.assets')
    @include('partials.branding')
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-50 via-slate-50 to-slate-100 font-sans text-slate-900 antialiased">

{{-- Navbar --}}
<header class="sticky top-0 z-50 glass border-b border-white/40">
    <div class="relative">
        {{-- Gradient accent line --}}
        <div class="absolute inset-x-0 top-0 h-[2px] bg-brand-gradient opacity-80"></div>

        <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-3 sm:px-6">
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl shadow-brand transition-transform group-hover:scale-105 overflow-hidden" style="background: var(--brand-gradient)">
                    <img src="{{ asset(\App\Models\Setting::getValue('favicon_path', 'favicon.png')) }}" alt="Logo" class="h-7 w-7 object-contain" onerror="this.style.display='none';this.parentNode.innerHTML='<svg class=&quot;h-5 w-5 text-white&quot; fill=&quot;none&quot; viewBox=&quot;0 0 24 24&quot; stroke=&quot;currentColor&quot; stroke-width=&quot;2&quot;><path stroke-linecap=&quot;round&quot; stroke-linejoin=&quot;round&quot; d=&quot;M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253&quot;/></svg>'">
                </div>
                <div class="leading-tight">
                    <div class="text-sm font-bold font-display text-slate-900">{{ \App\Models\Setting::getValue('navbar_title', 'Rekrutmen Guru') }}</div>
                    <div class="text-xs font-medium" style="color: var(--brand-primary)">{{ \App\Models\Setting::getValue('navbar_subtitle', 'SMA AFBS') }}</div>
                </div>
            </a>
            <nav class="flex items-center gap-1 sm:gap-2">
                <a href="{{ route('status.form') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-600 transition-all hover:bg-brand-light hover:text-brand">
                    Cek Status
                </a>
                <a href="{{ route('admin.login') }}" class="inline-flex items-center justify-center gap-1.5 rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-semibold text-slate-800 shadow-sm transition-all hover:border-brand-light hover:bg-brand-light hover:text-brand">
                    <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 7a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M4 20a8 8 0 0116 0"/></svg>
                    <span class="sm:hidden">Admin</span>
                    <span class="hidden sm:inline">Admin/Panitia</span>
                </a>
                <a href="{{ route('applications.create') }}" class="btn-primary text-sm">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    Daftar
                </a>
            </nav>
        </div>
    </div>
</header>

<main class="mx-auto max-w-6xl px-4 py-8 sm:px-6">
    <div class="space-y-5">
        @include('partials.flash')
        {{ $slot ?? '' }}
        @yield('content')
    </div>
</main>

<footer class="border-t border-slate-200/60 bg-white/60 backdrop-blur">
    <div class="mx-auto max-w-6xl px-4 py-6 sm:px-6">
        <div class="flex flex-col items-center justify-between gap-2 sm:flex-row">
            <div class="text-sm text-slate-500">{{ \App\Models\Setting::getValue('footer_text', '© ' . date('Y') . ' SMA AFBS — Sistem Rekrutmen') }}</div>
            <div class="flex items-center gap-1 text-xs text-slate-400">
                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                {{ \App\Models\Setting::getValue('powered_by', 'Powered by Laravel') }}
            </div>
        </div>
    </div>
</footer>

</body>
</html>
