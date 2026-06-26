@php($hasViteManifest = file_exists(public_path('build/manifest.json')))

{{-- Google Fonts --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Outfit:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

@if ($hasViteManifest)
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@else
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui'],
                        display: ['Outfit', 'ui-sans-serif', 'system-ui'],
                    },
                    colors: {
                        brand: {
                            50: '#eef2ff', 100: '#e0e7ff', 200: '#c7d2fe', 300: '#a5b4fc',
                            400: '#818cf8', 500: '#6366f1', 600: '#4f46e5', 700: '#4338ca',
                            800: '#3730a3', 900: '#312e81', 950: '#1e1b4b'
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, sans-serif; }
        .font-display { font-family: 'Outfit', ui-sans-serif, system-ui, sans-serif; }
    </style>
@endif

{{-- Design System CSS --}}
<style>
    :root {
        --glass-bg: rgba(255,255,255,0.7);
        --glass-border: rgba(255,255,255,0.3);
        --shadow-soft: 0 1px 3px rgba(0,0,0,0.04), 0 4px 12px rgba(0,0,0,0.06);
        --shadow-card: 0 1px 2px rgba(0,0,0,0.03), 0 8px 24px rgba(0,0,0,0.08);
    }

    /* Glassmorphism */
    .glass { background: rgba(255,255,255,0.88); backdrop-filter: blur(16px) saturate(180%); border: 1px solid rgba(203,213,225,0.9); }
    .glass-dark { background: rgba(30,27,75,0.85); backdrop-filter: blur(16px) saturate(180%); border: 1px solid rgba(var(--brand-rgb,99,102,241),0.2); }

    /* Gradients */
    .bg-brand-gradient { background: var(--brand-gradient); }
    .bg-brand-gradient-dark { background: var(--brand-gradient-dark); }
    .text-gradient { background: var(--brand-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }

    /* Shadows */
    .shadow-brand { box-shadow: var(--shadow-brand); }
    .shadow-soft { box-shadow: var(--shadow-soft); }
    .shadow-card { box-shadow: var(--shadow-card); }

    /* Animations */
    @keyframes fadeInUp { from { opacity:0; transform:translateY(20px); } to { opacity:1; transform:translateY(0); } }
    @keyframes fadeIn { from { opacity:0; } to { opacity:1; } }
    @keyframes slideInLeft { from { opacity:0; transform:translateX(-20px); } to { opacity:1; transform:translateX(0); } }
    @keyframes slideInRight { from { opacity:0; transform:translateX(20px); } to { opacity:1; transform:translateX(0); } }
    @keyframes scaleIn { from { opacity:0; transform:scale(0.9); } to { opacity:1; transform:scale(1); } }
    @keyframes shimmer { 0% { background-position: -200% 0; } 100% { background-position: 200% 0; } }
    @keyframes pulse-glow { 0%,100% { box-shadow: 0 0 20px rgba(var(--brand-rgb,99,102,241),0.15); } 50% { box-shadow: 0 0 30px rgba(var(--brand-rgb,99,102,241),0.3); } }
    @keyframes float { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-8px); } }
    @keyframes checkmark { 0% { stroke-dashoffset: 100; } 100% { stroke-dashoffset: 0; } }
    @keyframes blob { 0%,100% { border-radius: 60% 40% 30% 70%/60% 30% 70% 40%; } 50% { border-radius: 30% 60% 70% 40%/50% 60% 30% 60%; } }

    .animate-fade-in-up { animation: fadeInUp 0.6s ease-out both; }
    .animate-fade-in { animation: fadeIn 0.5s ease-out both; }
    .animate-slide-in-left { animation: slideInLeft 0.5s ease-out both; }
    .animate-slide-in-right { animation: slideInRight 0.5s ease-out both; }
    .animate-scale-in { animation: scaleIn 0.4s ease-out both; }
    .animate-float { animation: float 6s ease-in-out infinite; }
    .animate-blob { animation: blob 7s ease-in-out infinite; }
    .animate-pulse-glow { animation: pulse-glow 3s ease-in-out infinite; }

    /* Stagger delays */
    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }
    .delay-3 { animation-delay: 0.3s; }
    .delay-4 { animation-delay: 0.4s; }
    .delay-5 { animation-delay: 0.5s; }
    .delay-6 { animation-delay: 0.6s; }

    /* Modern Input Styling */
    .input-modern {
        width: 100%; padding: 0.625rem 0.875rem; border-radius: 0.75rem;
        border: 1.5px solid #e2e8f0; background: white;
        transition: all 0.2s ease;
        font-size: 0.875rem;
    }
    .input-modern:focus {
        outline: none; border-color: var(--brand-primary, #818cf8);
        box-shadow: 0 0 0 3px rgba(var(--brand-rgb,129,140,248),0.15);
    }

    /* Modern Button */
    .btn-primary {
        display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem;
        padding: 0.625rem 1.25rem; border-radius: 0.75rem;
        background: var(--brand-gradient); color: white;
        font-weight: 600; font-size: 0.875rem;
        transition: all 0.2s ease; border: none; cursor: pointer;
    }
    .btn-primary:hover { transform: translateY(-1px); box-shadow: var(--shadow-brand); }
    .btn-primary:active { transform: translateY(0); }

    .btn-secondary {
        display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem;
        padding: 0.625rem 1.25rem; border-radius: 0.75rem;
        background: white; color: #334155; border: 1.5px solid #e2e8f0;
        font-weight: 600; font-size: 0.875rem;
        transition: all 0.2s ease; cursor: pointer;
    }
    .btn-secondary:hover { background: #f8fafc; border-color: #cbd5e1; transform: translateY(-1px); }

    .btn-wa {
        display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem;
        padding: 0.625rem 1.25rem; border-radius: 0.75rem;
        background: linear-gradient(135deg, #22c55e, #16a34a); color: white;
        font-weight: 600; font-size: 0.875rem;
        transition: all 0.2s ease; border: none; cursor: pointer;
    }
    .btn-wa:hover { transform: translateY(-1px); box-shadow: 0 4px 16px rgba(34,197,94,0.3); }

    /* Card */
    .card { background: white; border-radius: 1rem; border: 1px solid #f1f5f9; box-shadow: var(--shadow-soft); }
    .card-glass { background: var(--glass-bg); backdrop-filter: blur(12px); border-radius: 1rem; border: 1px solid var(--glass-border); }

    /* Animated blob backgrounds */
    .blob-1 { position:absolute; width:300px; height:300px; background:rgba(var(--brand-rgb,99,102,241),0.12); filter:blur(60px); animation: blob 7s ease-in-out infinite; }
    .blob-2 { position:absolute; width:250px; height:250px; background:rgba(var(--brand-secondary-rgb,139,92,246),0.1); filter:blur(60px); animation: blob 7s ease-in-out infinite reverse; }

    /* Nav link active */
    .nav-link-active { background: linear-gradient(135deg, rgba(var(--brand-rgb,99,102,241),0.1), rgba(var(--brand-secondary-rgb,139,92,246),0.05)); color: var(--brand-primary, #4f46e5); font-weight: 600; }
    .sidebar-active { background: linear-gradient(135deg, rgba(var(--brand-rgb,99,102,241),0.15), rgba(var(--brand-secondary-rgb,139,92,246),0.08)); color: var(--brand-primary, #6366f1); border-left: 3px solid var(--brand-primary, #6366f1); }

    /* Smooth scroll */
    html { scroll-behavior: smooth; }

    /* Table hover */
    .table-row-hover:hover { background: #f8fafc; }

    /* Hide scrollbar but allow scroll */
    .scrollbar-hide::-webkit-scrollbar { display: none; }
    .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }

    /* Readability contrast */
    body { color: #0f172a; }
    .text-slate-300 { color: #64748b !important; }
    .text-slate-400 { color: #64748b !important; }
    .text-slate-500 { color: #475569 !important; }
    .text-slate-600 { color: #334155 !important; }
    .text-slate-700 { color: #1e293b !important; }
    .text-white\/70 { color: rgba(255,255,255,0.88) !important; }
    .text-white\/80 { color: rgba(255,255,255,0.94) !important; }
    .bg-white\/10 { background-color: rgba(255,255,255,0.18) !important; }
    .bg-white\/15 { background-color: rgba(255,255,255,0.24) !important; }
    .bg-slate-50\/50 { background-color: rgba(248,250,252,0.95) !important; }
    .border-slate-100 { border-color: #e2e8f0 !important; }
    .divide-slate-50 > :not([hidden]) ~ :not([hidden]) { border-color: #e2e8f0 !important; }
    .card { border-color: #e2e8f0; box-shadow: 0 1px 3px rgba(15,23,42,0.08), 0 8px 24px rgba(15,23,42,0.08); }
    .card-glass { background: rgba(255,255,255,0.92); border-color: #cbd5e1; }
    .input-modern { color: #0f172a; border-color: #cbd5e1; }
    .input-modern::placeholder { color: #64748b; opacity: 1; }
    .table-row-hover:hover { background: #f1f5f9; }
</style>

{{-- Motion.dev vanilla JS --}}
<script src="https://cdn.jsdelivr.net/npm/motion@11/dist/motion.min.js" defer></script>

<script defer>
    document.addEventListener('DOMContentLoaded', function() {
        // Stagger animate elements with data-animate attribute
        if (typeof Motion !== 'undefined' && Motion.animate) {
            document.querySelectorAll('[data-animate="fade-up"]').forEach(function(el, i) {
                Motion.animate(el,
                    { opacity: [0, 1], transform: ['translateY(20px)', 'translateY(0)'] },
                    { duration: 0.5, delay: i * 0.08, easing: 'ease-out' }
                );
            });
            document.querySelectorAll('[data-animate="scale-in"]').forEach(function(el, i) {
                Motion.animate(el,
                    { opacity: [0, 1], transform: ['scale(0.92)', 'scale(1)'] },
                    { duration: 0.4, delay: i * 0.06, easing: 'ease-out' }
                );
            });
        }

        // Auto-dismiss flash messages
        document.querySelectorAll('[data-auto-dismiss]').forEach(function(el) {
            setTimeout(function() {
                el.style.transition = 'opacity 0.4s, transform 0.4s';
                el.style.opacity = '0';
                el.style.transform = 'translateY(-10px)';
                setTimeout(function() { el.remove(); }, 400);
            }, 5000);
        });

        // Count-up animation for numbers
        document.querySelectorAll('[data-count-up]').forEach(function(el) {
            var target = parseInt(el.getAttribute('data-count-up'));
            var duration = 1200;
            var start = 0;
            var startTime = null;
            function step(timestamp) {
                if (!startTime) startTime = timestamp;
                var progress = Math.min((timestamp - startTime) / duration, 1);
                var eased = 1 - Math.pow(1 - progress, 3);
                el.textContent = Math.floor(eased * target);
                if (progress < 1) requestAnimationFrame(step);
            }
            requestAnimationFrame(step);
        });
    });
</script>
