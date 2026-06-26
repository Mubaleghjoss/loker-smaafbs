{{-- Branding Configuration - reads from database settings --}}
@php
    $siteName = \App\Models\Setting::getValue('site_name', 'Rekrutmen Guru SMA AFBS');
    $siteDescription = \App\Models\Setting::getValue('site_description', 'Sistem rekrutmen guru dan staf SMA Al Furqon Boarding School. Daftar, upload berkas, dan cek status lamaran secara online.');
    $siteUrl = config('app.url');
    $faviconFile = \App\Models\Setting::getValue('favicon_path', 'favicon.png');
    $ogImageFile = \App\Models\Setting::getValue('og_image_path', 'og-image.png');
    $brandColor = \App\Models\Setting::getValue('brand_color', '#6366f1');
    $brandColorSecondary = \App\Models\Setting::getValue('brand_color_secondary', '#8b5cf6');
    $footerText = \App\Models\Setting::getValue('footer_text', '© ' . date('Y') . ' SMA AFBS — Sistem Rekrutmen');
    $navbarTitle = \App\Models\Setting::getValue('navbar_title', 'Rekrutmen Guru');
    $navbarSubtitle = \App\Models\Setting::getValue('navbar_subtitle', 'SMA AFBS');
    $heroTitle = \App\Models\Setting::getValue('hero_title', "Rekrutmen Guru\nSMA AFBS");
    $heroDescription = \App\Models\Setting::getValue('hero_description', 'Bergabunglah bersama kami membangun pendidikan berkualitas. Daftar sekarang dan jadilah bagian dari keluarga SMA Al Furqon Boarding School.');
    $poweredByText = \App\Models\Setting::getValue('powered_by', 'Powered by Laravel');
@endphp

{{-- Favicon --}}
<link rel="icon" type="image/png" href="{{ asset($faviconFile) }}?v={{ file_exists(public_path($faviconFile)) ? filemtime(public_path($faviconFile)) : time() }}">
<link rel="apple-touch-icon" href="{{ asset($faviconFile) }}">

{{-- SEO --}}
<meta name="description" content="{{ $siteDescription }}">
<meta name="author" content="SMA AFBS">
<meta name="theme-color" content="{{ $brandColor }}">

{{-- Open Graph (WhatsApp, Facebook, Telegram) --}}
<meta property="og:type" content="website">
<meta property="og:url" content="{{ $siteUrl }}">
<meta property="og:title" content="{{ $siteName }}">
<meta property="og:description" content="{{ $siteDescription }}">
<meta property="og:image" content="{{ asset($ogImageFile) }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:site_name" content="SMA AFBS">

{{-- Twitter Card --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $siteName }}">
<meta name="twitter:description" content="{{ $siteDescription }}">
<meta name="twitter:image" content="{{ asset($ogImageFile) }}">

{{-- Dynamic brand colors override --}}
@php
    // Convert hex to RGB for alpha channel support
    $hexToRgb = function($hex) {
        $hex = ltrim($hex, '#');
        return implode(', ', [hexdec(substr($hex,0,2)), hexdec(substr($hex,2,2)), hexdec(substr($hex,4,2))]);
    };
    $brandRgb = $hexToRgb($brandColor);
    $secondaryRgb = $hexToRgb($brandColorSecondary);
@endphp
<style>
    :root {
        --brand-primary: {{ $brandColor }};
        --brand-secondary: {{ $brandColorSecondary }};
        --brand-rgb: {{ $brandRgb }};
        --brand-secondary-rgb: {{ $secondaryRgb }};
        --brand-gradient: linear-gradient(135deg, {{ $brandColor }} 0%, {{ $brandColorSecondary }} 100%);
        --brand-gradient-dark: linear-gradient(135deg, {{ $brandColor }} 0%, {{ $brandColorSecondary }} 100%);
        --shadow-brand: 0 4px 24px -4px {{ $brandColor }}40;
    }

    /* Brand color utilities */
    .text-brand { color: var(--brand-primary) !important; }
    .text-brand-secondary { color: var(--brand-secondary) !important; }
    .bg-brand-light { background-color: rgba(var(--brand-rgb), 0.08) !important; }
    .bg-brand-lighter { background-color: rgba(var(--brand-rgb), 0.05) !important; }
    .border-brand-light { border-color: rgba(var(--brand-rgb), 0.2) !important; }
    .hover\:bg-brand-light:hover { background-color: rgba(var(--brand-rgb), 0.1) !important; }
    .hover\:text-brand:hover { color: var(--brand-primary) !important; }
    .hover\:border-brand-light:hover { border-color: rgba(var(--brand-rgb), 0.3) !important; }
    .ring-brand-light { --tw-ring-color: rgba(var(--brand-rgb), 0.15) !important; }
</style>
