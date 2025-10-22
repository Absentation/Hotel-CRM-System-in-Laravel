@extends('employee.layouts.app')

@section('title', 'Alerts')

@section('content')
    <header style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:1rem;">
        <h1>My Alerts</h1>
        <a href="{{ route('employee.alerts.create') }}" role="button">Send Alert</a>
    </header>

    <table>
        <thead>
        <tr>
            <th>Subject</th>
            <th>Status</th>
            <th>Sent</th>
        </tr>
        </thead>
        <tbody>
        @forelse($alerts as $alert)
            <tr>
                <td>{{ $alert->subject }}</td>
                <td>{{ ucfirst($alert->status) }}</td>
                <td>{{ $alert->created_at->format('Y-m-d H:i') }}</td>
            </tr>
        @empty
            <tr><td colspan="3">No alerts yet.</td></tr>
        @endforelse
        </tbody>
    </table>

    {{ $alerts->links() }}
@endsection
