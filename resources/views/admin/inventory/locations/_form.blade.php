@csrf
<label>
    Name
    <input type="text" name="name" value="{{ old('name', $location->name) }}" required>
</label>

<label>
    Slug
    <input type="text" name="slug" value="{{ old('slug', $location->slug) }}">
    <small>Leave blank to auto-generate.</small>
</label>

<label>
    Type
    <input type="text" name="location_type" value="{{ old('location_type', $location->location_type) }}">
</label>

<label>
    Area
    <input type="text" name="area" value="{{ old('area', $location->area) }}">
</label>

<label>
    Description
    <textarea name="description" rows="3">{{ old('description', $location->description) }}</textarea>
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
