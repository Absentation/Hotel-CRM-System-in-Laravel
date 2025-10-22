<?php

namespace App\Http\Requests\Admin\Media;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMediaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user('admin') !== null;
    }

    public function rules(): array
    {
        return [
            'title' => ['nullable', 'string', 'max:255'],
            'media_type' => ['required', Rule::in(['image', 'video'])],
            'file' => ['nullable', 'file', 'max:51200', 'mimetypes:image/jpeg,image/png,image/webp,video/mp4,video/webm'],
            'thumbnail' => ['nullable', 'image', 'max:10240'],
            'is_published' => ['sometimes', 'boolean'],
            'display_order' => ['nullable', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_published' => $this->boolean('is_published'),
        ]);
    }
}
