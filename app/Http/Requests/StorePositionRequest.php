<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePositionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:150'],
            'slug' => ['nullable', 'string', 'max:180', 'alpha_dash', 'unique:positions,slug'],
            'description' => ['nullable', 'string', 'max:5000'],
            'requirements' => ['nullable', 'string', 'max:8000'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:65535'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama posisi wajib diisi.',
            'name.max' => 'Nama posisi maksimal 150 karakter.',
            'slug.alpha_dash' => 'Slug hanya boleh berisi huruf, angka, strip (-) dan underscore (_).',
            'slug.unique' => 'Slug sudah dipakai oleh posisi lain.',
            'slug.max' => 'Slug maksimal 180 karakter.',
            'description.max' => 'Deskripsi maksimal 5000 karakter.',
            'requirements.max' => 'Persyaratan maksimal 8000 karakter.',
            'sort_order.integer' => 'Urutan harus berupa angka.',
            'sort_order.min' => 'Urutan tidak boleh kurang dari 0.',
        ];
    }
}
