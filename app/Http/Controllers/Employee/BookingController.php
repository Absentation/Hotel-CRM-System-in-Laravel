<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Booking\StoreBookingRequest;
use App\Http\Requests\Admin\Booking\UpdateBookingRequest;
use App\Models\AdminAlert;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\Room;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function index(): View
    {
        $bookings = Booking::with(['customer', 'room'])
            ->latest('check_in_date')
            ->paginate(15);

        return view('employee.bookings.index', compact('bookings'));
    }

    public function create(): View
    {
        return view('employee.bookings.create', [
            'booking' => new Booking(),
            'customers' => Customer::orderBy('first_name')->get(),
            'rooms' => Room::orderBy('name')->get(),
        ]);
    }

    public function store(StoreBookingRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $booking = Booking::create([
            'booking_date' => now()->toDateString(),
            'check_in_date' => $data['check_in_date'],
            'expected_check_out' => $data['expected_check_out'],
            'special_request' => $data['special_request'] ?? null,
            'customer_id' => $data['customer_id'],
            'room_id' => $data['room_id'],
            'employee_id' => auth('employee')->id(),
            'username' => $data['username'],
            'password' => bcrypt($data['password']),
        ]);

        return redirect()->route('employee.bookings.index')->with('success', 'Booking created successfully.');
    }

    public function edit(Booking $booking): View
    {
        return view('employee.bookings.edit', [
            'booking' => $booking,
            'customers' => Customer::orderBy('first_name')->get(),
            'rooms' => Room::orderBy('name')->get(),
        ]);
    }

    public function update(UpdateBookingRequest $request, Booking $booking): RedirectResponse
    {
        $data = $request->validated();

        $update = [
            'check_in_date' => $data['check_in_date'],
            'expected_check_out' => $data['expected_check_out'],
            'special_request' => $data['special_request'] ?? null,
            'customer_id' => $data['customer_id'],
            'room_id' => $data['room_id'],
            'username' => $data['username'],
        ];

        if (! empty($data['password'])) {
            $update['password'] = bcrypt($data['password']);
        }

        $booking->update($update);

        return redirect()->route('employee.bookings.index')->with('success', 'Booking updated successfully.');
    }

    public function destroy(Booking $booking): RedirectResponse
    {
        $booking->delete();

        return redirect()->route('employee.bookings.index')->with('success', 'Booking deleted successfully.');
    }

    public function transfer(Booking $booking, Request $request): RedirectResponse
    {
        $data = $request->validate([
            'room_id' => ['required', 'exists:rooms,id'],
        ]);

        $booking->update(['room_id' => $data['room_id']]);

        AdminAlert::create([
            'employee_id' => auth('employee')->id(),
            'subject' => 'Room transfer requested',
            'message' => "Booking #{$booking->id} moved to room ID {$data['room_id']}",
        ]);

        return redirect()->route('employee.bookings.index')->with('success', 'Room transferred successfully.');
    }
}
