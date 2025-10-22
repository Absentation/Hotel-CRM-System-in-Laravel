@extends('admin.layouts.app')

@section('title', 'Additional Services')

@section('content')
    <header style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:1rem;">
        <h1>Additional Services</h1>
        <a href="{{ route('admin.services.create') }}" role="button">New Service</a>
    </header>

    <table>
        <thead>
        <tr>
            <th>Name</th>
            <th>Price</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @forelse($services as $service)
            <tr>
                <td><a href="{{ route('admin.services.show', $service) }}">{{ $service->name }}</a></td>
                <td>${{ number_format($service->price, 2) }}</td>
                <td style="text-align:right;">
                    <a href="{{ route('admin.services.edit', $service) }}">Edit</a>
                    <form action="{{ route('admin.services.destroy', $service) }}" method="POST" style="display:inline-block;margin-left:0.5rem;" onsubmit="return confirm('Delete this service?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="secondary outline">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3">No services found.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    {{ $services->links() }}
@endsection
