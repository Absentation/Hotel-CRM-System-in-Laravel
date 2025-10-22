@extends('admin.layouts.app')

@section('title', 'Edit Inventory Location')

@section('content')
    <h1>Edit Inventory Location</h1>
    <form method="POST" action="{{ route('admin.inventory.locations.update', $location) }}">
        @method('PUT')
        @include('admin.inventory.locations._form')
    </form>
@endsection
