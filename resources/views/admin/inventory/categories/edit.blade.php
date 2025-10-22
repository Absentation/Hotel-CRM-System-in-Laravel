@extends('admin.layouts.app')

@section('title', 'Edit Category')

@section('content')
    <h1>Edit Category</h1>
    <form method="POST" action="{{ route('admin.inventory.categories.update', $category) }}">
        @method('PUT')
        @include('admin.inventory.categories._form')
    </form>
@endsection
