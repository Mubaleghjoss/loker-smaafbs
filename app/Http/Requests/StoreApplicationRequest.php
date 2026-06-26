<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreApplicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'position_id' => ['nullable', 'integer', 'exists:positions,id'],
            'position_title' => ['required_without:position_id', 'string', 'max:150'],

            'full_name' => ['required', 'string', 'max:150'],
            'email' => ['nullable', 'email', 'max:190'],

            'birth_place' => ['required', 'string', 'max:120'],
            'birth_date' => ['required', 'date'],

            'address' => ['required', 'string', 'max:2000'],
            'domicile' => ['required', 'string', 'max:120'],
            'whatsapp' => ['required', 'string', 'max:30'],

            'last_education' => ['required', 'string', 'max:60'],
            'major' => ['required', 'string', 'max:120'],
            'campus' => ['required', 'string', 'max:150'],

            'connected_address' => ['required', 'string', 'max:200'],

            'expected_salary' => ['nullable', 'integer', 'min:0', 'max:100000000'],

            'cv' => ['required', 'file', 'mimes:pdf', 'max:3072'],
            'diploma' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:4096'],
        ];
    }

    public function messages(): array
    {
        return [
            'cv.mimes' => 'CV wajib PDF.',
            'diploma.mimes' => 'Ijazah wajib PDF/JPG/PNG.',
        ];
    }
}
