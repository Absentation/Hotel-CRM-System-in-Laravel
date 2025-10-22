@extends('admin.layouts.app')

@section('title', 'Inventory Transactions')

@section('content')
    <header class="flex-between" style="display:flex;justify-content:space-between;align-items:center;gap:1rem;">
        <h1>Inventory Transactions</h1>
        <a href="{{ route('admin.inventory.transactions.create') }}" role="button">Record Transaction</a>
    </header>

    <table>
        <thead>
        <tr>
            <th>Date</th>
            <th>Item</th>
            <th>Type</th>
            <th>Quantity</th>
            <th>Location</th>
            <th>By</th>
        </tr>
        </thead>
        <tbody>
        @forelse($transactions as $transaction)
            <tr>
                <td><a href="{{ route('admin.inventory.transactions.show', $transaction) }}">{{ $transaction->occurred_at->format('Y-m-d H:i') }}</a></td>
                <td>{{ $transaction->item?->name ?? '—' }}</td>
                <td>{{ ucfirst(str_replace('_', ' ', $transaction->transaction_type)) }}</td>
                <td>{{ number_format($transaction->quantity, 3) }}</td>
                <td>{{ $transaction->location?->name ?? '—' }}</td>
                <td>{{ $transaction->employee?->name ?? '—' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="6">No transactions recorded.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    {{ $transactions->links() }}
@endsection
