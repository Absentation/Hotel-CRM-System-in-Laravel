@csrf
<label>
    Full name
    <input type="text" name="name" value="{{ old('name', $employee->name) }}" required>
</label>

<label>
    Username
    <input type="text" name="username" value="{{ old('username', $employee->username) }}" required>
</label>

<label>
    Role
    <input type="text" name="role" value="{{ old('role', $employee->role) }}" required>
</label>

<label>
    Password @if($employee->exists)<small>(leave blank to keep current password)</small>@endif
    <input type="password" name="password">
</label>

<label>
    Confirm password
    <input type="password" name="password_confirmation">
</label>

<fieldset>
    <legend>Permissions</legend>
    @foreach($permissions as $permission)
        <label>
            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                @checked(in_array($permission->id, old('permissions', $employee->permissions->pluck('id')->toArray())))>
            {{ $permission->display_name ?? $permission->name }}
        </label>
    @endforeach
</fieldset>

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
