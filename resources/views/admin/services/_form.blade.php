@csrf
<label>
    Name
    <input type="text" name="name" value="{{ old('name', $service->name) }}" required>
</label>

<label>
    Price
    <input type="number" name="price" value="{{ old('price', $service->price) }}" step="0.01" min="0" required>
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
