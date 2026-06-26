<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAdminProfileRequest;
use App\Models\AdminUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        $admin = Auth::guard('admin')->user();
        abort_unless($admin instanceof AdminUser, 401);

        return view('admin.profile.edit', [
            'adminUser' => $admin,
        ]);
    }

    public function update(UpdateAdminProfileRequest $request)
    {
        $admin = Auth::guard('admin')->user();
        abort_unless($admin instanceof AdminUser, 401);

        $data = $request->validated();

        if (!Hash::check($data['current_password'], $admin->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah.']);
        }

        $update = [
            'email' => $data['email'],
        ];

        if (!empty($data['new_password'])) {
            $update['password'] = Hash::make($data['new_password']);
        }

        AdminUser::query()->whereKey($admin->id)->update($update);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
