@extends('employee.layouts.app')

@section('title', 'New Booking')

@section('content')
    <h1>Create Booking</h1>
    <form method="POST" action="{{ route('employee.bookings.store') }}">
        @include('employee.bookings._form')
    </form>
@endsection
