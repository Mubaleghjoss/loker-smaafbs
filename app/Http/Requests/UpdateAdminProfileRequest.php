<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAdminProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $admin = auth('admin')->user();
        $adminId = is_object($admin) ? ($admin->id ?? null) : null;

        return [
            'email' => ['required', 'email', 'max:190', Rule::unique('admin_users', 'email')->ignore($adminId)],
            'current_password' => ['required', 'string', 'max:255'],
            'new_password' => ['nullable', 'string', 'min:10', 'max:255'],
            'new_password_confirmation' => ['nullable', 'string', 'same:new_password'],
        ];
    }

    public function messages(): array
    {
        return [
            'new_password_confirmation.same' => 'Konfirmasi password baru tidak sama.',
        ];
    }
}
