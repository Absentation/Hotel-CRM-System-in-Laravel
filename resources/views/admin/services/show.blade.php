@extends('admin.layouts.app')

@section('title', $service->name)

@section('content')
    <h1>{{ $service->name }}</h1>
    <p><strong>Price:</strong> ${{ number_format($service->price, 2) }}</p>
    <a href="{{ route('admin.services.edit', $service) }}" role="button">Edit Service</a>
@endsection
