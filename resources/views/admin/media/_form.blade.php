@csrf
<label>
    Title
    <input type="text" name="title" value="{{ old('title', $media->title) }}">
</label>

<label>
    Media type
    <select name="media_type" required>
        <option value="image" @selected(old('media_type', $media->media_type) === 'image')>Image</option>
        <option value="video" @selected(old('media_type', $media->media_type) === 'video')>Video</option>
    </select>
</label>

<label>
    File @if($media->exists)<small>(leave blank to keep current)</small>@endif
    <input type="file" name="file" @if(!$media->exists) required @endif accept="image/*,video/*">
</label>

<label>
    Thumbnail (optional, images only)
    <input type="file" name="thumbnail" accept="image/*">
</label>

<label>
    Display order
    <input type="number" name="display_order" value="{{ old('display_order', $media->display_order ?? 0) }}" min="0">
</label>

<label>
    Published
    <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $media->is_published ?? true))>
</label>

<label>
    Description
    <textarea name="description" rows="3">{{ old('description', $media->description) }}</textarea>
</label>

@if ($errors->any())
    <article role="alert">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </article>
@endif

<button type="submit">Save</button>
