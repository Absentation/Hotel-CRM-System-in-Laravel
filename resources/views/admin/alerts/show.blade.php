@extends('admin.layouts.app')

@section('title', 'Alert Details')

@section('content')
    <h1>{{ $alert->subject }}</h1>
    <p><strong>From:</strong> {{ $alert->employee?->name ?? 'Unknown' }}</p>
    <p><strong>Status:</strong> {{ ucfirst($alert->status) }}</p>
    <p><strong>Message:</strong></p>
    <article>{{ $alert->message }}</article>

    <form method="POST" action="{{ route('admin.alerts.acknowledge', $alert) }}" style="display:inline-block;margin-right:0.5rem;">
        @csrf
        <button type="submit" class="secondary">Mark Acknowledged</button>
    </form>

    <form method="POST" action="{{ route('admin.alerts.resolve', $alert) }}" style="display:inline-block;">
        @csrf
        <button type="submit" class="contrast">Mark Resolved</button>
    </form>
@endsection
