@extends('admin.layouts.app')

@section('title', 'New Employee')

@section('content')
    <h1>Create Employee</h1>
    <form method="POST" action="{{ route('admin.employees.store') }}">
        @include('admin.employees._form')
    </form>
@endsection
