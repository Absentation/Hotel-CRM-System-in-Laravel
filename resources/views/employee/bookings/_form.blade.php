@csrf
<label>
    Guest
    <select name="customer_id" required>
        <option value="">Select guest</option>
        @foreach($customers as $customer)
            <option value="{{ $customer->id }}" @selected(old('customer_id', $booking->customer_id) == $customer->id)>
                {{ $customer->first_name }} {{ $customer->second_name }}
            </option>
        @endforeach
    </select>
</label>

<label>
    Room
    <select name="room_id" required>
        <option value="">Select room</option>
        @foreach($rooms as $room)
            <option value="{{ $room->id }}" @selected(old('room_id', $booking->room_id) == $room->id)>{{ $room->name }}</option>
        @endforeach
    </select>
</label>

<label>
    Check-in date
    <input type="date" name="check_in_date" value="{{ old('check_in_date', $booking->check_in_date) }}" required>
</label>

<label>
    Expected check-out
    <input type="date" name="expected_check_out" value="{{ old('expected_check_out', $booking->expected_check_out) }}">
</label>

<label>
    Special request
    <textarea name="special_request" rows="3">{{ old('special_request', $booking->special_request) }}</textarea>
</label>

<label>
    Portal username
    <input type="text" name="username" value="{{ old('username', $booking->username) }}" required>
</label>

<label>
    Portal password @if($booking->exists)<small>(leave blank to keep current)</small>@endif
    <input type="password" name="password">
</label>

<label>
    Confirm password
    <input type="password" name="password_confirmation">
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
