<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreHeroSlideRequest extends FormRequest
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
            'page' => ['required', 'string'],
            'image' => ['nullable', 'sometimes', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'headline' => ['nullable', 'string'],
            'subheadline' => ['nullable', 'string'],
            'cta_text' => ['nullable', 'string', 'max:100'],
            'cta_url' => ['nullable', 'url', 'max:255'],
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
            'page.required' => 'Please select a page for this hero slide.',
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'The image must be a JPG, JPEG, PNG, or WebP file.',
            'image.max' => 'The image must not exceed 5MB.',
            'cta_url.url' => 'Please enter a valid URL for the call-to-action link.',
        ];
    }
}
