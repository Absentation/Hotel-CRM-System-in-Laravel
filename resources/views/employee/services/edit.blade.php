@extends('employee.layouts.app')

@section('title', 'Edit Service')

@section('content')
    <h1>Edit Service</h1>
    <form method="POST" action="{{ route('employee.services.update', $service) }}">
        @method('PUT')
        @include('employee.services._form')
    </form>
@endsection
