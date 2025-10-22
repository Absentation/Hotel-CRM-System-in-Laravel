<?php

namespace App\Http\Requests\Admin\Booking;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user('admin') !== null;
    }

    public function rules(): array
    {
        $today = now()->startOfDay();

        return [
            'customer_id' => ['required', 'string', Rule::exists('customers', 'id')],
            'room_id' => ['required', 'integer', Rule::exists('rooms', 'id')],
            'check_in_date' => ['required', 'date', 'after_or_equal:' . $today->toDateString()],
            'expected_check_out' => ['nullable', 'date', 'after:check_in_date'],
            'special_request' => ['nullable', 'string'],
            'username' => ['required', 'alpha_dash', 'min:4', Rule::unique('bookings', 'username')],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->filled('check_in_date')) {
            $this->merge(['check_in_date' => date('Y-m-d', strtotime($this->check_in_date))]);
        }

        if ($this->filled('expected_check_out')) {
            $this->merge(['expected_check_out' => date('Y-m-d', strtotime($this->expected_check_out))]);
        }
    }
}
