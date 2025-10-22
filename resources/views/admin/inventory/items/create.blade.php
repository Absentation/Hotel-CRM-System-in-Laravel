@extends('admin.layouts.app')

@section('title', 'New Inventory Item')

@section('content')
    <h1>Create Inventory Item</h1>
    <form method="POST" action="{{ route('admin.inventory.items.store') }}">
        @include('admin.inventory.items._form')
    </form>
@endsection
