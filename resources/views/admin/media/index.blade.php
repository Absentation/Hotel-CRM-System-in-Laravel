@extends('admin.layouts.app')

@section('title', 'Media Library')

@section('content')
    <header style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:1rem;">
        <h1>Media Library</h1>
        <a href="{{ route('admin.media.create') }}" role="button">Upload Media</a>
    </header>

    <table>
        <thead>
        <tr>
            <th>Preview</th>
            <th>Title</th>
            <th>Type</th>
            <th>Published</th>
            <th>Order</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @forelse($media as $item)
            <tr>
                <td>
                    @if($item->media_type === 'image')
                        <img src="{{ asset('storage/' . $item->file_path) }}" alt="" style="height:60px;object-fit:cover;">
                    @else
                        <small>Video</small>
                    @endif
                </td>
                <td>{{ $item->title ?? '—' }}</td>
                <td>{{ ucfirst($item->media_type) }}</td>
                <td>{{ $item->is_published ? 'Yes' : 'No' }}</td>
                <td>{{ $item->display_order }}</td>
                <td style="text-align:right;white-space:nowrap;">
                    <a href="{{ route('admin.media.edit', $item) }}">Edit</a>
                    <form action="{{ route('admin.media.destroy', $item) }}" method="POST" style="display:inline-block;margin-left:0.5rem;" onsubmit="return confirm('Delete this media item?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="secondary outline">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6">No media uploaded yet.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    {{ $media->links() }}
@endsection
