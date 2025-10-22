@extends('admin.layouts.app')

@section('title', 'Inventory Categories')

@section('content')
    <header class="flex-between" style="display:flex;justify-content:space-between;align-items:center;gap:1rem;">
        <h1>Inventory Categories</h1>
        <a href="{{ route('admin.inventory.categories.create') }}" role="button">New Category</a>
    </header>

    <table>
        <thead>
        <tr>
            <th>Name</th>
            <th>Type</th>
            <th>Parent</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @forelse($categories as $category)
            <tr>
                <td><a href="{{ route('admin.inventory.categories.show', $category) }}">{{ $category->name }}</a></td>
                <td>{{ $category->category_type ?? '—' }}</td>
                <td>{{ $category->parent?->name ?? '—' }}</td>
                <td style="text-align:right;">
                    <a href="{{ route('admin.inventory.categories.edit', $category) }}">Edit</a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4">No categories defined yet.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    {{ $categories->links() }}
@endsection
