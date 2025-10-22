<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Booking\StoreBookingRequest;
use App\Http\Requests\Admin\Booking\UpdateBookingRequest;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\Log;
use App\Models\Room;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function index(): View
    {
        $bookings = Booking::query()
            ->with(['customer', 'room', 'employee'])
            ->latest('check_in_date')
            ->paginate(15);

        return view('admin.bookings.index', compact('bookings'));
    }

    public function create(): View
    {
        $customers = Customer::orderBy('first_name')->get();
        $rooms = Room::orderBy('name')->get();

        return view('admin.bookings.create', [
            'booking' => new Booking(),
            'customers' => $customers,
            'rooms' => $rooms,
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
            'employee_id' => $request->user('admin')->id,
            'username' => $data['username'],
            'password' => bcrypt($data['password']),
        ]);

        $this->logAction('booking_created', $booking->id, $booking->toArray());

        return redirect()
            ->route('admin.bookings.index')
            ->with('success', 'Booking created successfully.');
    }

    public function show(Booking $booking): View
    {
        $booking->load(['customer', 'room', 'employee', 'payments']);

        return view('admin.bookings.show', compact('booking'));
    }

    public function edit(Booking $booking): View
    {
        $customers = Customer::orderBy('first_name')->get();
        $rooms = Room::orderBy('name')->get();

        return view('admin.bookings.edit', compact('booking', 'customers', 'rooms'));
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

        $this->logAction('booking_updated', $booking->id, $booking->toArray());

        return redirect()
            ->route('admin.bookings.index')
            ->with('success', 'Booking updated successfully.');
    }

    public function destroy(Booking $booking): RedirectResponse
    {
        $this->logAction('booking_deleted', $booking->id, $booking->toArray());
        $booking->delete();

        return redirect()
            ->route('admin.bookings.index')
            ->with('success', 'Booking deleted.');
    }

    public function checkout(Booking $booking): RedirectResponse
    {
        if ($booking->check_out_date) {
            return redirect()
                ->route('admin.bookings.index')
                ->with('success', 'Booking already checked out.');
        }

        $booking->update(['check_out_date' => now()->toDateString()]);

        $this->logAction('booking_checked_out', $booking->id, $booking->toArray());

        return redirect()
            ->route('admin.bookings.index')
            ->with('success', 'Booking checked out successfully.');
    }

    public function availableRooms(): JsonResponse
    {
        $checkIn = request('check_in_date');
        $checkOut = request('expected_check_out');
        $bookingId = request('exclude');

        if (! $checkIn || ! $checkOut) {
            return response()->json(['rooms' => []]);
        }

        $rooms = Room::query()
            ->whereDoesntHave('bookings', function ($query) use ($checkIn, $checkOut, $bookingId) {
                $query->when($bookingId, fn ($q) => $q->where('id', '!=', $bookingId));
                $query->where(function ($q) use ($checkIn, $checkOut) {
                    $q->whereNull('check_out_date')
                        ->where(function ($overlap) use ($checkIn, $checkOut) {
                            $overlap->whereBetween('check_in_date', [$checkIn, $checkOut])
                                ->orWhereBetween('expected_check_out', [$checkIn, $checkOut])
                                ->orWhere(function ($between) use ($checkIn, $checkOut) {
                                    $between->where('check_in_date', '<=', $checkIn)
                                        ->where('expected_check_out', '>=', $checkOut);
                                });
                        });
                });
            })
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json(['rooms' => $rooms]);
    }

    protected function logAction(string $type, int $bookingId, array $object = []): void
    {
        Log::create([
            'log_type' => $type,
            'object' => json_encode(['booking_id' => $bookingId, ...$object]),
            'detail' => 'admin_action',
            'employee_id' => auth('admin')->id(),
        ]);
    }
}
