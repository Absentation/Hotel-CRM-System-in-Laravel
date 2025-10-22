@extends('admin.layouts.app')

@section('title', $location->name . ' Details')

@section('content')
    <h1>{{ $location->name }}</h1>
    <p><strong>Type:</strong> {{ $location->location_type ?? '—' }}</p>
    <p><strong>Area:</strong> {{ $location->area ?? '—' }}</p>
    <p><strong>Description:</strong> {{ $location->description ?? '—' }}</p>

    <section>
        <header>
            <h2>Current Stock</h2>
        </header>
        <table>
            <thead>
            <tr>
                <th>Item</th>
                <th>On Hand</th>
                <th>Reserved</th>
                <th>Available</th>
            </tr>
            </thead>
            <tbody>
            @forelse($location->stocks()->with('item')->orderByDesc('updated_at')->get() as $stock)
                <tr>
                    <td><a href="{{ route('admin.inventory.items.show', $stock->item) }}">{{ $stock->item->name }}</a></td>
                    <td>{{ number_format($stock->quantity_on_hand, 3) }}</td>
                    <td>{{ number_format($stock->quantity_reserved, 3) }}</td>
                    <td>{{ number_format($stock->quantity_available, 3) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No stock records yet.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </section>
@endsection
