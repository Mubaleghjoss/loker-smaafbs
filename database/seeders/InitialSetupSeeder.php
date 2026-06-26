<?php

namespace Database\Seeders;

use App\Models\AdminUser;
use App\Models\Position;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class InitialSetupSeeder extends Seeder
{
    public function run(): void
    {
        Setting::putValue('admin_whatsapp', env('AFBS_ADMIN_WHATSAPP', '+6283818393029'));
        Setting::putValue('mail_confirm_enabled', env('AFBS_MAIL_CONFIRM_ENABLED', '0'));

        if (AdminUser::query()->count() === 0) {
            $email = env('AFBS_ADMIN_EMAIL', 'admin@afbs.local');
            $password = env('AFBS_ADMIN_PASSWORD', 'ChangeMe123!');
            $name = env('AFBS_ADMIN_NAME', 'Admin AFBS');

            AdminUser::query()->create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'is_super' => true,
                'permissions' => [],
            ]);
        }

        if (Position::query()->count() === 0) {
            Position::query()->create([
                'name' => 'Guru Matematika',
                'description' => 'Mengajar Matematika SMA',
                'is_active' => true,
                'sort_order' => 1,
            ]);

            Position::query()->create([
                'name' => 'Guru Bahasa Inggris',
                'description' => 'Mengajar Bahasa Inggris SMA',
                'is_active' => true,
                'sort_order' => 2,
            ]);

            Position::query()->create([
                'name' => 'Staf Administrasi',
                'description' => 'Administrasi dan dukungan operasional',
                'is_active' => true,
                'sort_order' => 3,
            ]);
        }
    }
}
