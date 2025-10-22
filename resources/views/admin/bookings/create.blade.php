@extends('admin.layouts.app')

@section('title', 'New Booking')

@section('content')
    <h1>Create Booking</h1>
    <form method="POST" action="{{ route('admin.bookings.store') }}">
        @include('admin.bookings._form')
    </form>
@endsection
