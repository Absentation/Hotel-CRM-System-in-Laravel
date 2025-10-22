@extends('admin.layouts.app')

@section('title', 'Transaction Details')

@section('content')
    <h1>Transaction Details</h1>
    <p><strong>Item:</strong> <a href="{{ route('admin.inventory.items.show', $transaction->item) }}">{{ $transaction->item?->name ?? '—' }}</a></p>
    <p><strong>Type:</strong> {{ ucfirst(str_replace('_', ' ', $transaction->transaction_type)) }}</p>
    <p><strong>Quantity:</strong> {{ number_format($transaction->quantity, 3) }}</p>
    <p><strong>Location:</strong> {{ $transaction->location?->name ?? '—' }}</p>
    <p><strong>Employee:</strong> {{ $transaction->employee?->name ?? '—' }}</p>
    <p><strong>Unit Cost:</strong> {{ $transaction->unit_cost !== null ? number_format($transaction->unit_cost, 2) : '—' }}</p>
    <p><strong>Total Cost:</strong> {{ $transaction->total_cost !== null ? number_format($transaction->total_cost, 2) : '—' }}</p>
    <p><strong>Occurred At:</strong> {{ $transaction->occurred_at->format('Y-m-d H:i') }}</p>
    <p><strong>Notes:</strong> {{ $transaction->notes ?? '—' }}</p>
@endsection
