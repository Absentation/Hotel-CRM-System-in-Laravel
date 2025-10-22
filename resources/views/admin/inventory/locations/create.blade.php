@extends('admin.layouts.app')

@section('title', 'New Inventory Location')

@section('content')
    <h1>Create Inventory Location</h1>
    <form method="POST" action="{{ route('admin.inventory.locations.store') }}">
        @include('admin.inventory.locations._form')
    </form>
@endsection
