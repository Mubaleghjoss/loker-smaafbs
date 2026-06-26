<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Admin - Rekrutmen SMA AFBS' }}</title>
    @include('partials.branding')
    @include('partials.assets')
    <style>
        /* Sidebar - always fixed */
        .sidebar {
            position: fixed; top: 0; left: 0; bottom: 0; width: 260px; z-index: 50;
            display: flex; flex-direction: column; overflow: hidden;
        }
        .sidebar-nav-item {
            display: flex; align-items: center; gap: 0.75rem;
            padding: 0.5rem 0.875rem; border-radius: 0.5rem;
            font-size: 0.8125rem; font-weight: 500;
            color: rgba(148,163,184,1); transition: all 0.15s ease;
            text-decoration: none; margin-bottom: 2px;
        }
        .sidebar-nav-item:hover { background: rgba(255,255,255,0.06); color: #e2e8f0; }
        .sidebar-nav-item.active { background: rgba(99,102,241,0.15); color: #a5b4fc; font-weight: 600; }
        .sidebar-nav-item.active .nav-icon { color: #818cf8; }
        .sidebar-nav-item .nav-icon { width: 18px; height: 18px; flex-shrink: 0; }
        .sidebar-divider { height: 1px; background: rgba(255,255,255,0.06); margin: 0.75rem 0; }

        /* Desktop: sidebar always visible, content offset */
        @media (min-width: 1024px) {
            .sidebar { transform: translateX(0) !important; }
            .sidebar-backdrop { display: none !important; }
            .admin-main { margin-left: 260px; }
        }

        /* Mobile: sidebar slide in/out */
        @media (max-width: 1023px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s cubic-bezier(0.4,0,0.2,1);
            }
            .sidebar.open { transform: translateX(0); }
            .sidebar-backdrop {
                position: fixed; inset: 0; z-index: 40;
                background: rgba(0,0,0,0.5); backdrop-filter: blur(4px);
                opacity: 0; pointer-events: none; transition: opacity 0.3s ease;
            }
            .sidebar-backdrop.open { opacity: 1; pointer-events: auto; }
            .admin-main { margin-left: 0; }
        }
    </style>
</head>
<body class="min-h-screen bg-gray-50 font-sans text-slate-900 antialiased">
@php($admin = auth('admin')->user())
@php($currentRoute = request()->route()?->getName() ?? '')

{{-- Sidebar Backdrop --}}
<div id="sidebarBackdrop" class="sidebar-backdrop" onclick="toggleSidebar()"></div>

{{-- Sidebar --}}
<aside id="sidebar" class="sidebar bg-gradient-to-b from-slate-900 to-slate-950 flex flex-col">
    {{-- Logo area --}}
    <div class="flex items-center gap-3 px-5 py-4" style="border-bottom: 1px solid rgba(255,255,255,0.07);">
        <div class="flex items-center justify-center rounded-xl bg-brand-gradient" style="width:36px;height:36px;">
            <svg style="width:18px;height:18px;" class="text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
        </div>
        <div>
            <div style="font-size:0.875rem;font-weight:700;color:#fff;" class="font-display">Admin/Panitia</div>
            <div style="font-size:0.6875rem;color:#c7d2fe;">SMA AFBS</div>
        </div>
        {{-- Close button mobile --}}
        <button onclick="toggleSidebar()" class="ml-auto lg:hidden" style="color:#94a3b8;padding:4px;">
            <svg style="width:20px;height:20px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 overflow-y-auto px-3 py-3 scrollbar-hide">
        <div style="font-size:0.625rem;font-weight:600;color:rgba(148,163,184,0.5);letter-spacing:0.08em;text-transform:uppercase;padding:0.5rem 0.875rem 0.375rem;">
            Menu
        </div>

        @if ($admin && method_exists($admin, 'hasPermission') && $admin->hasPermission('dashboard.view'))
            <a href="{{ route('admin.dashboard') }}" class="sidebar-nav-item {{ str_starts_with($currentRoute, 'admin.dashboard') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>
        @endif

        @if ($admin && method_exists($admin, 'hasPermission') && $admin->hasPermission('applicants.view'))
            <a href="{{ route('admin.applicants.index') }}" class="sidebar-nav-item {{ str_starts_with($currentRoute, 'admin.applicants') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                Pelamar
            </a>
        @endif

        @if ($admin && method_exists($admin, 'hasPermission') && $admin->hasPermission('positions.manage'))
            <a href="{{ route('admin.positions.index') }}" class="sidebar-nav-item {{ str_starts_with($currentRoute, 'admin.positions') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                Lowongan
            </a>
        @endif

        <div class="sidebar-divider"></div>

        <div style="font-size:0.625rem;font-weight:600;color:rgba(148,163,184,0.5);letter-spacing:0.08em;text-transform:uppercase;padding:0.5rem 0.875rem 0.375rem;">
            Pengaturan
        </div>

        @if ($admin && method_exists($admin, 'hasPermission') && $admin->hasPermission('settings.manage'))
            <a href="{{ route('admin.settings.edit') }}" class="sidebar-nav-item {{ str_starts_with($currentRoute, 'admin.settings') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Pengaturan
            </a>
        @endif

        @if ($admin && method_exists($admin, 'hasPermission') && $admin->hasPermission('admin_users.manage'))
            <a href="{{ route('admin.admin-users.index') }}" class="sidebar-nav-item {{ str_starts_with($currentRoute, 'admin.admin-users') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                Pengguna Admin
            </a>
        @endif

        <a href="{{ route('admin.profile.edit') }}" class="sidebar-nav-item {{ str_starts_with($currentRoute, 'admin.profile') ? 'active' : '' }}">
            <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            Profil Saya
        </a>
    </nav>

    {{-- Bottom: Admin info + Logout --}}
    <div style="border-top: 1px solid rgba(255,255,255,0.07); padding: 1rem 0.75rem;">
        @if ($admin)
            <div style="display:flex;align-items:center;gap:0.625rem;padding:0 0.375rem 0.75rem;">
                <div style="width:32px;height:32px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:0.6875rem;font-weight:700;color:#c7d2fe;background:rgba(99,102,241,0.2);">
                    {{ strtoupper(substr($admin->name, 0, 2)) }}
                </div>
                <div style="min-width:0;flex:1;">
                    <div style="font-size:0.8125rem;font-weight:600;color:#fff;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $admin->name }}</div>
                    <div style="font-size:0.6875rem;color:#94a3b8;">{{ method_exists($admin, 'roleLabel') ? $admin->roleLabel() : ($admin->is_super ? 'Super Admin' : 'Panitia') }}</div>
                </div>
            </div>
        @endif
        <form method="post" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" style="display:flex;width:100%;align-items:center;justify-content:center;gap:0.5rem;padding:0.5rem;border-radius:0.5rem;font-size:0.8125rem;font-weight:500;color:#94a3b8;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.06);cursor:pointer;transition:all 0.15s;" onmouseover="this.style.background='rgba(255,255,255,0.08)';this.style.color='#e2e8f0'" onmouseout="this.style.background='rgba(255,255,255,0.04)';this.style.color='#94a3b8'">
                <svg style="width:16px;height:16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Keluar
            </button>
        </form>
    </div>
</aside>

{{-- Main content --}}
<div class="admin-main min-h-screen flex flex-col">
    {{-- Top bar --}}
    <header style="position:sticky;top:0;z-index:30;display:flex;align-items:center;justify-content:space-between;padding:0.75rem 1.5rem;background:rgba(255,255,255,0.85);backdrop-filter:blur(12px);border-bottom:1px solid rgba(226,232,240,0.6);">
        {{-- Mobile menu button --}}
        <button onclick="toggleSidebar()" class="lg:hidden" style="display:flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:0.5rem;border:1px solid #e2e8f0;background:white;cursor:pointer;color:#64748b;">
            <svg style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>

        <div style="font-size:0.8125rem;color:#94a3b8;font-weight:500;" class="hidden lg:block">
            {{ now()->translatedFormat('l, d F Y') }}
        </div>

        <div style="display:flex;align-items:center;gap:0.5rem;">
            @if ($admin)
                <div style="display:flex;align-items:center;gap:0.5rem;padding:0.375rem 0.75rem;border-radius:0.5rem;background:#f8fafc;">
                    <div style="width:24px;height:24px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:0.5625rem;font-weight:700;color:white;background:linear-gradient(135deg,#6366f1,#8b5cf6);">
                        {{ strtoupper(substr($admin->name, 0, 1)) }}
                    </div>
                    <span style="font-size:0.8125rem;font-weight:500;color:#334155;">{{ $admin->name }}</span>
                    <span class="hidden sm:inline-flex rounded-full bg-slate-200 px-2 py-0.5 text-[11px] font-bold text-slate-700">{{ method_exists($admin, 'roleLabel') ? $admin->roleLabel() : ($admin->is_super ? 'Super Admin' : 'Panitia') }}</span>
                </div>
            @endif
        </div>
    </header>

    {{-- Page content --}}
    <main style="flex:1;padding:1.5rem;">
        <div class="mx-auto max-w-6xl space-y-5">
            @include('partials.flash')
            @yield('content')
        </div>
    </main>
</div>

<script>
    function toggleSidebar() {
        var sidebar = document.getElementById('sidebar');
        var backdrop = document.getElementById('sidebarBackdrop');
        sidebar.classList.toggle('open');
        backdrop.classList.toggle('open');
    }
</script>

</body>
</html>
