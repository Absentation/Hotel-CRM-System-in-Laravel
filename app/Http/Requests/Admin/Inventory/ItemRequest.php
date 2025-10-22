<?php

namespace App\Http\Requests\Admin\Inventory;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user('admin') !== null;
    }

    public function rules(): array
    {
        $itemId = $this->route('item')?->id;

        return [
            'name' => ['required', 'string', 'max:255'],
            'sku' => [
                'nullable',
                'string',
                'max:100',
                Rule::unique('inventory_items', 'sku')->ignore($itemId),
            ],
            'unit' => ['required', 'string', 'max:50'],
            'unit_cost' => ['nullable', 'numeric', 'min:0'],
            'reorder_level' => ['nullable', 'integer', 'min:0'],
            'track_quantity' => ['sometimes', 'boolean'],
            'is_active' => ['sometimes', 'boolean'],
            'category_id' => ['required', 'exists:inventory_categories,id'],
            'location_id' => ['nullable', 'exists:inventory_locations,id'],
            'description' => ['nullable', 'string'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'track_quantity' => $this->boolean('track_quantity'),
            'is_active' => $this->boolean('is_active'),
        ]);
    }
}
