@extends('employee.layouts.app')

@section('title', 'Bookings')

@section('content')
    <header style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:1rem;">
        <h1>Bookings</h1>
        <a href="{{ route('employee.bookings.create') }}" role="button">New Booking</a>
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
                <td>{{ $booking->customer?->first_name }} {{ $booking->customer?->second_name }}</td>
                <td>{{ $booking->room?->name ?? '—' }}</td>
                <td>{{ $booking->check_in_date }}</td>
                <td>{{ $booking->expected_check_out ?? '—' }}</td>
                <td>{{ $booking->check_out_date ? 'Checked Out' : 'Active' }}</td>
                <td style="text-align:right;white-space:nowrap;">
                    <a href="{{ route('employee.bookings.edit', $booking) }}">Edit</a>
                    <form action="{{ route('employee.bookings.destroy', $booking) }}" method="POST" style="display:inline-block;margin-left:0.5rem;" onsubmit="return confirm('Delete this booking?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="secondary outline">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="6">No bookings yet.</td></tr>
        @endforelse
        </tbody>
    </table>

    {{ $bookings->links() }}
@endsection
