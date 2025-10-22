@extends('admin.layouts.app')

@section('title', 'Record Inventory Transaction')

@section('content')
    <h1>Record Inventory Transaction</h1>
    <form method="POST" action="{{ route('admin.inventory.transactions.store') }}">
        @csrf
        <label>
            Item
            <select name="item_id" required>
                <option value="">Select item</option>
                @foreach($items as $item)
                    <option value="{{ $item->id }}" @selected(old('item_id', request('item_id')) == $item->id)>
                        {{ $item->name }} @if($item->sku) ({{ $item->sku }}) @endif
                    </option>
                @endforeach
            </select>
        </label>

        <label>
            Location
            <select name="location_id">
                <option value="">Default item location</option>
                @foreach($locations as $location)
                    <option value="{{ $location->id }}" @selected(old('location_id') == $location->id)>{{ $location->name }}</option>
                @endforeach
            </select>
        </label>

        <label>
            Transaction type
            <select name="transaction_type" required>
                @foreach($transactionTypes as $value => $label)
                    <option value="{{ $value }}" @selected(old('transaction_type') == $value)>{{ $label }}</option>
                @endforeach
            </select>
        </label>

        <label>
            Quantity
            <input type="number" name="quantity" value="{{ old('quantity', 1) }}" step="0.001" min="0.001" required>
        </label>

        <label>
            Unit cost
            <input type="number" name="unit_cost" value="{{ old('unit_cost') }}" step="0.01" min="0">
            <small>Leave blank to use the item default.</small>
        </label>

        <label>
            Total cost
            <input type="number" name="total_cost" value="{{ old('total_cost') }}" step="0.01" min="0">
        </label>

        <label>
            Occurred at
            <input type="datetime-local" name="occurred_at" value="{{ old('occurred_at', now()->format('Y-m-d\TH:i')) }}">
        </label>

        <label>
            Notes
            <textarea name="notes" rows="3">{{ old('notes') }}</textarea>
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

        <button type="submit">Record</button>
    </form>
@endsection
