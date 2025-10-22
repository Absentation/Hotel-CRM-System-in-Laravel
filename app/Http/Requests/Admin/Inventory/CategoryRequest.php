<?php

namespace App\Http\Requests\Admin\Inventory;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user('admin') !== null;
    }

    public function rules(): array
    {
        $categoryId = $this->route('category')?->id;

        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('inventory_categories', 'slug')->ignore($categoryId),
            ],
            'category_type' => ['nullable', 'string', 'max:100'],
            'parent_id' => [
                'nullable',
                'integer',
                Rule::exists('inventory_categories', 'id')->where(function ($query) use ($categoryId) {
                    if ($categoryId) {
                        $query->where('id', '!=', $categoryId);
                    }
                }),
            ],
            'description' => ['nullable', 'string'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => $this->filled('slug') ? $this->slug : null,
            'parent_id' => $this->filled('parent_id') ? (int) $this->parent_id : null,
        ]);
    }
}
