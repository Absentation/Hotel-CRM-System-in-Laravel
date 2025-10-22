@csrf
<label>
    Name
    <input type="text" name="name" value="{{ old('name', $category->name) }}" required>
</label>

<label>
    Slug
    <input type="text" name="slug" value="{{ old('slug', $category->slug) }}">
</label>

<label>
    Type
    <input type="text" name="category_type" value="{{ old('category_type', $category->category_type) }}">
</label>

<label>
    Parent Category
    <select name="parent_id">
        <option value="">None</option>
        @foreach($parents as $id => $name)
            <option value="{{ $id }}" @selected(old('parent_id', $category->parent_id) == $id)>{{ $name }}</option>
        @endforeach
    </select>
</label>

<label>
    Description
    <textarea name="description" rows="3">{{ old('description', $category->description) }}</textarea>
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
