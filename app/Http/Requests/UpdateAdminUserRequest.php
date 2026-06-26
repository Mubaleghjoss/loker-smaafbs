<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAdminUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $adminUser = $this->route('admin_user');
        $adminUserId = is_object($adminUser) ? ($adminUser->id ?? null) : null;

        $allowedPermissions = array_keys(config('admin_permissions'));

        return [
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:190', Rule::unique('admin_users', 'email')->ignore($adminUserId)],
            'password' => ['nullable', 'string', 'min:10', 'max:255'],
            'is_super' => ['nullable', 'boolean'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string', Rule::in($allowedPermissions)],
        ];
    }
}
