@extends('admin.layouts.app')

@section('title', 'New Service')

@section('content')
    <h1>Create Service</h1>
    <form method="POST" action="{{ route('admin.services.store') }}">
        @include('admin.services._form')
    </form>
@endsection
