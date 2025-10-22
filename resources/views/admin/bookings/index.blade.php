@extends('admin.layouts.app')

@section('title', 'Bookings')

@section('content')
    <header style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:1rem;">
        <h1>Bookings</h1>
        <a href="{{ route('admin.bookings.create') }}" role="button">New Booking</a>
    </header>

    <table>
        <thead>
        <tr>
            <th>Guest</th>
            <th>Room</th>
            <th>Check-in</th>
            <th>Check-out</th>
            <th>Status</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @forelse($bookings as $booking)
            <tr>
                <td><a href="{{ route('admin.bookings.show', $booking) }}">{{ $booking->customer?->first_name }} {{ $booking->customer?->second_name }}</a></td>
                <td>{{ $booking->room?->name ?? '—' }}</td>
                <td>{{ $booking->check_in_date }}</td>
                <td>{{ $booking->expected_check_out ?? '—' }}</td>
                <td>{{ $booking->check_out_date ? 'Checked Out' : 'Active' }}</td>
                <td style="text-align:right; white-space:nowrap;">
                    <a href="{{ route('admin.bookings.edit', $booking) }}">Edit</a>
                    @if(!$booking->check_out_date)
                        <form action="{{ route('admin.bookings.checkout', $booking) }}" method="POST" style="display:inline-block;margin-left:0.5rem;" onsubmit="return confirm('Confirm checkout for this booking?');">
                            @csrf
                            <button type="submit" class="secondary outline">Checkout</button>
                        </form>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6">No bookings found.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    {{ $bookings->links() }}
@endsection
