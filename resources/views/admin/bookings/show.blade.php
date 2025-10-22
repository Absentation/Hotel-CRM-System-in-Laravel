@extends('admin.layouts.app')

@section('title', 'Booking Details')

@section('content')
    <h1>Booking #{{ $booking->id }}</h1>
    <p><strong>Guest:</strong> {{ $booking->customer?->first_name }} {{ $booking->customer?->second_name }}</p>
    <p><strong>Room:</strong> {{ $booking->room?->name ?? '—' }}</p>
    <p><strong>Check-in:</strong> {{ $booking->check_in_date }}</p>
    <p><strong>Expected check-out:</strong> {{ $booking->expected_check_out ?? '—' }}</p>
    <p><strong>Actual check-out:</strong> {{ $booking->check_out_date ?? '—' }}</p>
    <p><strong>Special request:</strong> {{ $booking->special_request ?? '—' }}</p>
    <p><strong>Portal username:</strong> {{ $booking->username }}</p>

    <h2>Payments</h2>
    <table>
        <thead>
        <tr>
            <th>Date</th>
            <th>Amount</th>
        </tr>
        </thead>
        <tbody>
        @forelse($booking->payments as $payment)
            <tr>
                <td>{{ $payment->pay_date }}</td>
                <td>${{ number_format($payment->amount, 2) }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="2">No payments recorded.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endsection
