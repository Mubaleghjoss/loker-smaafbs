<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdminUserRequest;
use App\Http\Requests\UpdateAdminUserRequest;
use App\Models\AdminUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['admin.permission:admin_users.manage']);
    }

    public function index()
    {
        $adminUsers = AdminUser::query()->orderByDesc('is_super')->orderBy('name')->paginate(20);

        return view('admin.admin_users.index', [
            'adminUsers' => $adminUsers,
        ]);
    }

    public function create()
    {
        return view('admin.admin_users.create', [
            'permissions' => config('admin_permissions'),
        ]);
    }

    public function store(StoreAdminUserRequest $request)
    {
        $data = $request->validated();

        AdminUser::query()->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'is_super' => (bool)($data['is_super'] ?? false),
            'permissions' => !empty($data['permissions']) ? array_values($data['permissions']) : [],
        ]);

        return redirect()->route('admin.admin-users.index')->with('success', 'Admin baru berhasil dibuat.');
    }

    public function edit(AdminUser $admin_user)
    {
        return view('admin.admin_users.edit', [
            'adminUser' => $admin_user,
            'permissions' => config('admin_permissions'),
        ]);
    }

    public function update(UpdateAdminUserRequest $request, AdminUser $admin_user)
    {
        $data = $request->validated();

        $update = [
            'name' => $data['name'],
            'email' => $data['email'],
            'is_super' => (bool)($data['is_super'] ?? false),
            'permissions' => !empty($data['permissions']) ? array_values($data['permissions']) : [],
        ];

        if (!empty($data['password'])) {
            $update['password'] = Hash::make($data['password']);
        }

        $admin_user->update($update);

        return redirect()->route('admin.admin-users.index')->with('success', 'Admin berhasil diperbarui.');
    }

    public function destroy(AdminUser $admin_user)
    {
        $current = Auth::guard('admin')->user();
        if ($current instanceof AdminUser && $current->id === $admin_user->id) {
            return back()->withErrors(['delete' => 'Tidak bisa menghapus akun yang sedang login.']);
        }

        if ($admin_user->is_super && AdminUser::query()->where('is_super', true)->count() <= 1) {
            return back()->withErrors(['delete' => 'Tidak bisa menghapus super admin terakhir.']);
        }

        $admin_user->delete();

        return redirect()->route('admin.admin-users.index')->with('success', 'Admin berhasil dihapus.');
    }
}
