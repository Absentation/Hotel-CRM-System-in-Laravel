@extends('admin.layouts.app')

@section('title', $category->name)

@section('content')
    <h1>{{ $category->name }}</h1>
    <p><strong>Type:</strong> {{ $category->category_type ?? '—' }}</p>
    <p><strong>Parent:</strong> {{ $category->parent?->name ?? '—' }}</p>
    <p><strong>Description:</strong> {{ $category->description ?? '—' }}</p>

    <section>
        <header>
            <h2>Items in this Category</h2>
        </header>
        <table>
            <thead>
            <tr>
                <th>Name</th>
                <th>Unit</th>
                <th>Active</th>
            </tr>
            </thead>
            <tbody>
            @forelse($category->items()->orderBy('name')->get() as $item)
                <tr>
                    <td><a href="{{ route('admin.inventory.items.show', $item) }}">{{ $item->name }}</a></td>
                    <td>{{ $item->unit }}</td>
                    <td>{{ $item->is_active ? 'Yes' : 'No' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">No items assigned to this category.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </section>
@endsection
