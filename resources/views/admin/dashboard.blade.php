@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <header style="margin-bottom:1.5rem;">
        <h1>Welcome back, {{ auth('admin')->user()->name }}</h1>
        <p>Here is a snapshot of bookings, revenue, and inventory health.</p>
    </header>

    <section style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:1rem;">
        <article>
            <header><strong>Bookings</strong></header>
            <ul>
                <li>Total: {{ number_format($bookingSummary['totals']['overall']) }}</li>
                <li>Active stays: {{ number_format($bookingSummary['totals']['active']) }}</li>
                <li>Arrivals today: {{ number_format($bookingSummary['totals']['today']) }}</li>
                <li>Upcoming arrivals: {{ number_format($bookingSummary['totals']['upcoming']) }}</li>
            </ul>
        </article>
        <article>
            <header><strong>Revenue</strong></header>
            <ul>
                <li>All time: ${{ number_format($paymentSummary['totals']['overall'], 2) }}</li>
                <li>This month: ${{ number_format($paymentSummary['totals']['this_month'], 2) }}</li>
                <li>This year: ${{ number_format($paymentSummary['totals']['this_year'], 2) }}</li>
            </ul>
        </article>
        <article>
            <header><strong>Inventory Alerts</strong></header>
            <p>
                Low stock items: {{ $inventoryAlerts['low_stock']->count() }}
            </p>
            <p>
                Recent transactions (7 days): {{ $inventoryAlerts['recent_transactions']->count() }}
            </p>
        </article>
    </section>

    <section style="margin-top:2rem;">
        <header style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:0.5rem;">
            <h2>Bookings (last 6 months)</h2>
        </header>
        <table>
            <thead>
            <tr>
                <th>Month</th>
                <th>Bookings</th>
            </tr>
            </thead>
            <tbody>
            @foreach($bookingSummary['by_month'] as $row)
                <tr>
                    <td>{{ $row['period'] }}</td>
                    <td>{{ number_format($row['total']) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </section>

    <section style="margin-top:2rem;">
        <header style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:0.5rem;">
            <h2>Revenue (last 6 months)</h2>
        </header>
        <table>
            <thead>
            <tr>
                <th>Month</th>
                <th>Total Revenue</th>
            </tr>
            </thead>
            <tbody>
            @foreach($paymentSummary['by_month'] as $row)
                <tr>
                    <td>{{ $row['period'] }}</td>
                    <td>${{ number_format($row['total'], 2) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </section>

    <section style="margin-top:2rem;">
        <header style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:0.5rem;">
            <h2>Low Stock Alerts</h2>
            <a href="{{ route('admin.inventory.items.index') }}">Manage inventory</a>
        </header>
        <table>
            <thead>
            <tr>
                <th>Item</th>
                <th>Category</th>
                <th>On hand</th>
                <th>Reorder level</th>
            </tr>
            </thead>
            <tbody>
            @forelse($inventoryAlerts['low_stock'] as $item)
                <tr>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['category'] ?? '—' }}</td>
                    <td>{{ number_format($item['on_hand'], 3) }}</td>
                    <td>{{ number_format($item['reorder_level']) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No items are currently below reorder levels.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </section>

    <section style="margin-top:2rem;">
        <header style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:0.5rem;">
            <h2>Recent Inventory Transactions</h2>
            <a href="{{ route('admin.inventory.transactions.index') }}">View all</a>
        </header>
        <table>
            <thead>
            <tr>
                <th>Date</th>
                <th>Item</th>
                <th>Type</th>
                <th>Quantity</th>
                <th>Location</th>
                <th>Employee</th>
            </tr>
            </thead>
            <tbody>
            @forelse($inventoryAlerts['recent_transactions'] as $transaction)
                <tr>
                    <td>{{ $transaction['occurred_at']->format('Y-m-d H:i') }}</td>
                    <td>{{ $transaction['item'] ?? '—' }}</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $transaction['type'])) }}</td>
                    <td>{{ number_format($transaction['quantity'], 3) }}</td>
                    <td>{{ $transaction['location'] ?? '—' }}</td>
                    <td>{{ $transaction['employee'] ?? '—' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No recent transactions.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </section>
@endsection
