@csrf
<label>
    Name
    <input type="text" name="name" value="{{ old('name', $item->name) }}" required>
</label>

<label>
    SKU
    <input type="text" name="sku" value="{{ old('sku', $item->sku) }}">
</label>

<label>
    Unit of measure
    <input type="text" name="unit" value="{{ old('unit', $item->unit ?? 'each') }}" required>
</label>

<label>
    Unit cost
    <input type="number" name="unit_cost" value="{{ old('unit_cost', $item->unit_cost) }}" step="0.01" min="0">
</label>

<label>
    Reorder level
    <input type="number" name="reorder_level" value="{{ old('reorder_level', $item->reorder_level) }}" min="0">
</label>

<label>
    Category
    <select name="category_id" required>
        <option value="">Select category</option>
        @foreach($categories as $id => $name)
            <option value="{{ $id }}" @selected(old('category_id', $item->category_id) == $id)>{{ $name }}</option>
        @endforeach
    </select>
</label>

<label>
    Default Location
    <select name="location_id">
        <option value="">None</option>
        @foreach($locations as $id => $name)
            <option value="{{ $id }}" @selected(old('location_id', $item->location_id) == $id)>{{ $name }}</option>
        @endforeach
    </select>
</label>

<fieldset>
    <label>
        <input type="checkbox" name="track_quantity" value="1" @checked(old('track_quantity', $item->track_quantity ?? true))>
        Track quantity
    </label>
    <label>
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $item->is_active ?? true))>
        Active
    </label>
</fieldset>

<label>
    Description
    <textarea name="description" rows="3">{{ old('description', $item->description) }}</textarea>
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
