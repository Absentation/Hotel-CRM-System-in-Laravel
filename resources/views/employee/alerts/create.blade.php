@extends('employee.layouts.app')

@section('title', 'Send Alert')

@section('content')
    <h1>Notify Administrators</h1>
    <form method="POST" action="{{ route('employee.alerts.store') }}">
        @csrf
        <label>
            Subject
            <input type="text" name="subject" value="{{ old('subject') }}" required>
        </label>
        <label>
            Message
            <textarea name="message" rows="5" required>{{ old('message') }}</textarea>
        </label>

        @if ($errors->any())
            <article role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </article>
        @endif

        <button type="submit">Send Alert</button>
    </form>
@endsection
