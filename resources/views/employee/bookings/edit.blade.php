@extends('employee.layouts.app')

@section('title', 'Edit Booking')

@section('content')
    <h1>Edit Booking</h1>
    <form method="POST" action="{{ route('employee.bookings.update', $booking) }}">
        @method('PUT')
        @include('employee.bookings._form')
    </form>

    <form method="POST" action="{{ route('employee.bookings.transfer', $booking) }}" style="margin-top:1.5rem;">
        @csrf
        <label>
            Transfer to room
            <select name="room_id" required>
                @foreach($rooms as $room)
                    <option value="{{ $room->id }}">{{ $room->name }}</option>
                @endforeach
            </select>
        </label>
        <button type="submit" class="secondary">Transfer Room</button>
    </form>
@endsection
