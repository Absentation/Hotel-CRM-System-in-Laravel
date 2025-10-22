<?php

namespace App\Http\Requests\Admin\Booking;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user('admin') !== null;
    }

    public function rules(): array
    {
        $bookingId = $this->route('booking')?->id;

        return [
            'customer_id' => ['required', 'string', Rule::exists('customers', 'id')],
            'room_id' => ['required', 'integer', Rule::exists('rooms', 'id')],
            'check_in_date' => ['required', 'date'],
            'expected_check_out' => ['nullable', 'date', 'after:check_in_date'],
            'special_request' => ['nullable', 'string'],
            'username' => ['required', 'alpha_dash', 'min:4', Rule::unique('bookings', 'username')->ignore($bookingId)],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ];
    }

    protected function prepareForValidation(): void
    {
        foreach (['check_in_date', 'expected_check_out'] as $field) {
            if ($this->filled($field)) {
                $this->merge([$field => date('Y-m-d', strtotime($this->$field))]);
            }
        }
    }
}
