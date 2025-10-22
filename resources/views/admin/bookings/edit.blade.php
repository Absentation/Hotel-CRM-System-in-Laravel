@extends('admin.layouts.app')

@section('title', 'Edit Booking')

@section('content')
    <h1>Edit Booking</h1>
    <form method="POST" action="{{ route('admin.bookings.update', $booking) }}">
        @method('PUT')
        @include('admin.bookings._form')
    </form>
@endsection
