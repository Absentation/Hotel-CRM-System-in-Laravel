@extends('admin.layouts.app')

@section('title', $item->name)

@section('content')
    <h1>{{ $item->name }}</h1>
    <p><strong>SKU:</strong> {{ $item->sku ?? '—' }}</p>
    <p><strong>Category:</strong> {{ $item->category?->name ?? '—' }}</p>
    <p><strong>Default Location:</strong> {{ $item->location?->name ?? '—' }}</p>
    <p><strong>Unit:</strong> {{ $item->unit }}</p>
    <p><strong>Unit Cost:</strong> {{ $item->unit_cost ? number_format($item->unit_cost, 2) : '—' }}</p>
    <p><strong>Reorder Level:</strong> {{ $item->reorder_level ?? '—' }}</p>
    <p><strong>Tracking:</strong> {{ $item->track_quantity ? 'Yes' : 'No' }}</p>
    <p><strong>Status:</strong> {{ $item->is_active ? 'Active' : 'Inactive' }}</p>
    <p><strong>Description:</strong> {{ $item->description ?? '—' }}</p>

    <section>
        <header>
            <h2>Stock by Location</h2>
        </header>
        <table>
            <thead>
            <tr>
                <th>Location</th>
                <th>On Hand</th>
                <th>Reserved</th>
                <th>Available</th>
                <th>Last Audited</th>
            </tr>
            </thead>
            <tbody>
            @forelse($item->stocks as $stock)
                <tr>
                    <td>{{ $stock->location?->name ?? 'Unassigned' }}</td>
                    <td>{{ number_format($stock->quantity_on_hand, 3) }}</td>
                    <td>{{ number_format($stock->quantity_reserved, 3) }}</td>
                    <td>{{ number_format($stock->quantity_available, 3) }}</td>
                    <td>{{ optional($stock->last_audited_at)->format('Y-m-d H:i') ?? '—' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No stock records.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </section>

    <section>
        <header style="display:flex;justify-content:space-between;align-items:center;">
            <h2>Recent Transactions</h2>
            <a href="{{ route('admin.inventory.transactions.create') }}?item_id={{ $item->id }}">Record Transaction</a>
        </header>
        <table>
            <thead>
            <tr>
                <th>Date</th>
                <th>Type</th>
                <th>Quantity</th>
                <th>Location</th>
                <th>Employee</th>
            </tr>
            </thead>
            <tbody>
            @forelse($item->transactions as $transaction)
                <tr>
                    <td>{{ $transaction->occurred_at->format('Y-m-d H:i') }}</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $transaction->transaction_type)) }}</td>
                    <td>{{ number_format($transaction->quantity, 3) }}</td>
                    <td>{{ $transaction->location?->name ?? '—' }}</td>
                    <td>{{ $transaction->employee?->name ?? '—' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No transactions yet.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </section>
@endsection
