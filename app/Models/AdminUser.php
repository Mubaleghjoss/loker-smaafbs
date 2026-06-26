<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class AdminUser extends Authenticatable
{
    use Notifiable;

    protected $table = 'admin_users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_super',
        'permissions',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'is_super' => 'boolean',
        'permissions' => 'array',
        'last_login_at' => 'datetime',
    ];

    public function hasPermission(string $permission): bool
    {
        if ($this->is_super) {
            return true;
        }

        $perms = $this->permissions ?? [];

        return in_array($permission, $perms, true);
    }

    public function hasAnyPermission(array $permissions): bool
    {
        foreach ($permissions as $permission) {
            if ($this->hasPermission($permission)) {
                return true;
            }
        }

        return false;
    }

    public function firstAllowedRouteName(): string
    {
        $routes = [
            'dashboard.view' => 'admin.dashboard',
            'positions.manage' => 'admin.positions.index',
            'applicants.view' => 'admin.applicants.index',
            'settings.manage' => 'admin.settings.edit',
            'admin_users.manage' => 'admin.admin-users.index',
        ];

        foreach ($routes as $permission => $route) {
            if ($this->hasPermission($permission)) {
                return $route;
            }
        }

        return 'admin.profile.edit';
    }

    public function roleLabel(): string
    {
        return $this->is_super ? 'Super Admin' : 'Panitia';
    }
}
