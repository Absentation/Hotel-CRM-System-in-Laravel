@extends('admin.layouts.app')

@section('title', 'Upload Media')

@section('content')
    <h1>Upload Media</h1>
    <form method="POST" action="{{ route('admin.media.store') }}" enctype="multipart/form-data">
        @include('admin.media._form')
    </form>
@endsection
