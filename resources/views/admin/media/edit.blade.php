@extends('admin.layouts.app')

@section('title', 'Edit Media')

@section('content')
    <h1>Edit Media</h1>
    <form method="POST" action="{{ route('admin.media.update', $media) }}" enctype="multipart/form-data">
        @method('PUT')
        @include('admin.media._form')
    </form>
@endsection
