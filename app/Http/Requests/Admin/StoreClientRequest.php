<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:200'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:5120'],
            'sector' => ['nullable', 'string', 'max:100'],
            'show_in_marquee' => ['boolean'],
            'show_in_clients_page' => ['boolean'],
            'sort_order' => ['integer', 'min:0'],
            'is_active' => ['boolean'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Please enter the client name.',
            'name.max' => 'Client name must not exceed 200 characters.',
            'logo.image' => 'The file must be an image.',
            'logo.mimes' => 'The logo must be a JPG, JPEG, PNG, WebP, or SVG file.',
            'logo.max' => 'The logo must not exceed 5MB.',
        ];
    }
}
