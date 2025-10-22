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
    <select name="room_id" id="roomSelect" required>
        <option value="">Select room</option>
        @foreach($rooms as $room)
            <option value="{{ $room->id }}" @selected(old('room_id', $booking->room_id) == $room->id)>
                {{ $room->name }}
            </option>
        @endforeach
    </select>
    <small id="roomHelp">Select dates first and click "Check availability".</small>
</label>

<label>
    Check-in date
    <input type="date" name="check_in_date" id="checkInInput" value="{{ old('check_in_date', $booking->check_in_date) }}" required>
</label>

<label>
    Expected check-out
    <input type="date" name="expected_check_out" id="checkOutInput" value="{{ old('expected_check_out', $booking->expected_check_out) }}">
</label>

<button type="button" class="secondary" id="checkRoomsButton">Check availability</button>

<label>
    Special requests
    <textarea name="special_request" rows="3">{{ old('special_request', $booking->special_request) }}</textarea>
</label>

<label>
    Guest portal username
    <input type="text" name="username" value="{{ old('username', $booking->username) }}" required>
</label>

<label>
    Password @if($booking->exists)<small>(leave blank to keep current)</small>@endif
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

@push('scripts')
    <script>
        document.getElementById('checkRoomsButton')?.addEventListener('click', async function () {
            const checkIn = document.getElementById('checkInInput').value;
            const checkOut = document.getElementById('checkOutInput').value;
            const select = document.getElementById('roomSelect');
            const help = document.getElementById('roomHelp');

            if (!checkIn || !checkOut) {
                alert('Please select both check-in and expected check-out dates.');
                return;
            }

            const params = new URLSearchParams({
                check_in_date: checkIn,
                expected_check_out: checkOut,
                exclude: '{{ $booking->id ?? '' }}'
            });

            const response = await fetch('{{ route('admin.bookings.available') }}?' + params.toString(), {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const data = await response.json();
            select.innerHTML = '<option value="">Select room</option>';
            data.rooms.forEach(room => {
                const option = document.createElement('option');
                option.value = room.id;
                option.textContent = room.name;
                select.appendChild(option);
            });

            if (data.rooms.length === 0) {
                help.textContent = 'No rooms available for selected dates.';
            } else {
                help.textContent = data.rooms.length + ' rooms available.';
            }
        });
    </script>
@endpush
