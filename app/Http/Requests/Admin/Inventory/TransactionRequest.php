<?php

namespace App\Http\Requests\Admin\Inventory;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user('admin') !== null;
    }

    public function rules(): array
    {
        $types = ['receipt', 'issue', 'adjustment_in', 'adjustment_out', 'waste'];

        return [
            'item_id' => ['required', 'exists:inventory_items,id'],
            'location_id' => ['nullable', 'exists:inventory_locations,id'],
            'transaction_type' => ['required', Rule::in($types)],
            'quantity' => ['required', 'numeric', 'gt:0'],
            'unit_cost' => ['nullable', 'numeric', 'min:0'],
            'total_cost' => ['nullable', 'numeric', 'min:0'],
            'occurred_at' => ['nullable', 'date'],
            'notes' => ['nullable', 'string'],
            'meta' => ['nullable', 'array'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'location_id' => $this->filled('location_id') ? (int) $this->location_id : null,
            'unit_cost' => $this->filled('unit_cost') ? $this->unit_cost : null,
            'total_cost' => $this->filled('total_cost') ? $this->total_cost : null,
            'occurred_at' => $this->filled('occurred_at') ? $this->occurred_at : now(),
        ]);
    }
}
