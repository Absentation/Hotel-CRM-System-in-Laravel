@extends('admin.layouts.app')

@section('title', 'Inventory Items')

@section('content')
    <header class="flex-between" style="display:flex;justify-content:space-between;align-items:center;gap:1rem;">
        <h1>Inventory Items</h1>
        <div style="display:flex;gap:0.5rem;">
            <a href="{{ route('admin.inventory.transactions.create') }}" role="button" class="secondary">Record Transaction</a>
            <a href="{{ route('admin.inventory.items.create') }}" role="button">New Item</a>
        </div>
    </header>

    <table>
        <thead>
        <tr>
            <th>Name</th>
            <th>SKU</th>
            <th>Category</th>
            <th>Location</th>
            <th>Tracking</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @forelse($items as $item)
            <tr>
                <td><a href="{{ route('admin.inventory.items.show', $item) }}">{{ $item->name }}</a></td>
                <td>{{ $item->sku ?? '—' }}</td>
                <td>{{ $item->category?->name ?? '—' }}</td>
                <td>{{ $item->location?->name ?? '—' }}</td>
                <td>{{ $item->track_quantity ? 'Yes' : 'No' }}</td>
                <td style="text-align:right;">
                    <a href="{{ route('admin.inventory.items.edit', $item) }}">Edit</a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6">No items found.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    {{ $items->links() }}
@endsection
