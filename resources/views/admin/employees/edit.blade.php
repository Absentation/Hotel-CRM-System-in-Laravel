@extends('admin.layouts.app')

@section('title', 'Edit Employee')

@section('content')
    <h1>Edit Employee</h1>
    <form method="POST" action="{{ route('admin.employees.update', $employee) }}">
        @method('PUT')
        @include('admin.employees._form')
    </form>

    <form method="POST" action="{{ route('admin.employees.reset-password', $employee) }}" style="margin-top:1.5rem;">
        @csrf
        <button type="submit" class="secondary outline" onclick="return confirm('Reset password to username?')">Reset password to username</button>
    </form>
@endsection
