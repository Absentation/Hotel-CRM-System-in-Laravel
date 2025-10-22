@extends('admin.layouts.app')

@section('title', 'Edit Service')

@section('content')
    <h1>Edit Service</h1>
    <form method="POST" action="{{ route('admin.services.update', $service) }}">
        @method('PUT')
        @include('admin.services._form')
    </form>
@endsection
