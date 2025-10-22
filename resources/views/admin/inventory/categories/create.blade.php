@extends('admin.layouts.app')

@section('title', 'New Category')

@section('content')
    <h1>Create Category</h1>
    <form method="POST" action="{{ route('admin.inventory.categories.store') }}">
        @include('admin.inventory.categories._form')
    </form>
@endsection
