@extends('admin.layouts.app')

@section('title', 'Edit Inventory Item')

@section('content')
    <h1>Edit Inventory Item</h1>
    <form method="POST" action="{{ route('admin.inventory.items.update', $item) }}">
        @method('PUT')
        @include('admin.inventory.items._form')
    </form>
@endsection
