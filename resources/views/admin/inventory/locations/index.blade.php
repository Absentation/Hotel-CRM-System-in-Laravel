@extends('admin.layouts.app')

@section('title', 'Inventory Locations')

@section('content')
    <header class="flex-between" style="display:flex;justify-content:space-between;align-items:center;gap:1rem;">
        <h1>Inventory Locations</h1>
        <a href="{{ route('admin.inventory.locations.create') }}" role="button">New Location</a>
    </header>

    <table>
        <thead>
        <tr>
            <th>Name</th>
            <th>Type</th>
            <th>Area</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @forelse($locations as $location)
            <tr>
                <td><a href="{{ route('admin.inventory.locations.show', $location) }}">{{ $location->name }}</a></td>
                <td>{{ $location->location_type ?? '—' }}</td>
                <td>{{ $location->area ?? '—' }}</td>
                <td style="text-align:right;">
                    <a href="{{ route('admin.inventory.locations.edit', $location) }}">Edit</a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4">No locations defined yet.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    {{ $locations->links() }}
@endsection
