@extends('layouts.admin')

@section('content')
    <div class="flex flex-wrap items-end justify-between gap-4 animate-fade-in-up">
        <div>
            <h1 class="font-display text-2xl font-bold text-slate-900">Pengguna Admin/Panitia</h1>
            <p class="mt-1 text-sm text-slate-500">Super admin bisa membuat akun panitia dan mengatur akses menu.</p>
        </div>
        <a href="{{ route('admin.admin-users.create') }}" class="btn-primary">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
            Tambah Admin/Panitia
        </a>
    </div>

    <div class="mt-5 card overflow-hidden animate-fade-in-up delay-1">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/50">
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Admin/Panitia</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Email</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Role</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Akses</th>
                        <th class="px-5 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach ($adminUsers as $u)
                        <tr class="table-row-hover transition-colors">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-9 w-9 items-center justify-center rounded-full {{ $u->is_super ? 'bg-gradient-to-br from-amber-400 to-orange-500' : 'bg-gradient-to-br from-indigo-400 to-violet-500' }} text-xs font-bold text-white">
                                        {{ strtoupper(substr($u->name, 0, 2)) }}
                                    </div>
                                    <span class="font-medium text-slate-900">{{ $u->name }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 text-sm text-slate-600">{{ $u->email }}</td>
                            <td class="px-5 py-3.5">
                                @if ($u->is_super)
                                    <span class="inline-flex items-center gap-1 rounded-full bg-gradient-to-r from-amber-50 to-orange-50 px-2.5 py-0.5 text-xs font-bold text-amber-700 ring-1 ring-amber-200/50">
                                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                        Super Admin
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-bold text-slate-700">Panitia</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5">
                                @if ($u->is_super)
                                    <span class="text-xs font-medium text-slate-500">Semua akses</span>
                                @else
                                    @php($perms = $u->permissions ?? [])
                                    <span class="inline-flex items-center rounded-full bg-indigo-50 px-2 py-0.5 text-xs font-semibold text-indigo-700">{{ count($perms) }} izin</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('admin.admin-users.edit', $u) }}" class="rounded-lg px-3 py-1.5 text-xs font-semibold text-indigo-600 hover:bg-indigo-50 transition-colors">Edit</a>
                                    <form class="inline" method="post" action="{{ route('admin.admin-users.destroy', $u) }}" onsubmit="return confirm('Hapus admin ini?')">
                                        @csrf @method('DELETE')
                                        <button class="rounded-lg px-3 py-1.5 text-xs font-semibold text-rose-600 hover:bg-rose-50 transition-colors">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">{{ $adminUsers->links() }}</div>
@endsection
