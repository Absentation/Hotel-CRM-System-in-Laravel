@extends('admin.layouts.app')

@section('title', $employee->name)

@section('content')
    <h1>{{ $employee->name }}</h1>
    <p><strong>Username:</strong> {{ $employee->username }}</p>
    <p><strong>Role:</strong> {{ $employee->role }}</p>
    <p><strong>Permissions:</strong> {{ $employee->permissions->pluck('display_name')->implode(', ') ?: '—' }}</p>

    <a href="{{ route('admin.employees.edit', $employee) }}" role="button">Edit Employee</a>
@endsection
