@extends('admin.layouts.app')

@section('title', 'Employee Alerts')

@section('content')
    <h1>Employee Alerts</h1>

    <table>
        <thead>
        <tr>
            <th>Subject</th>
            <th>Employee</th>
            <th>Status</th>
            <th>Created</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @forelse($alerts as $alert)
            <tr>
                <td>{{ $alert->subject }}</td>
                <td>{{ $alert->employee?->name ?? '—' }}</td>
                <td>{{ ucfirst($alert->status) }}</td>
                <td>{{ $alert->created_at->format('Y-m-d H:i') }}</td>
                <td style="text-align:right;"><a href="{{ route('admin.alerts.show', $alert) }}">View</a></td>
            </tr>
        @empty
            <tr><td colspan="5">No alerts at this time.</td></tr>
        @endforelse
        </tbody>
    </table>

    {{ $alerts->links() }}
@endsection
