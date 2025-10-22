@extends('employee.layouts.app')

@section('title', 'New Service')

@section('content')
    <h1>Create Service</h1>
    <form method="POST" action="{{ route('employee.services.store') }}">
        @include('employee.services._form')
    </form>
@endsection
