@extends('admin.layouts.app')

@section('title', 'Employees')

@section('content')
    <header style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:1rem;">
        <h1>Employees</h1>
        <a href="{{ route('admin.employees.create') }}" role="button">New Employee</a>
    </header>

    <table>
        <thead>
        <tr>
            <th>Name</th>
            <th>Username</th>
            <th>Role</th>
            <th>Permissions</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @forelse($employees as $employee)
            <tr>
                <td><a href="{{ route('admin.employees.show', $employee) }}">{{ $employee->name }}</a></td>
                <td>{{ $employee->username }}</td>
                <td>{{ $employee->role }}</td>
                <td>
                    {{ $employee->permissions->pluck('display_name')->implode(', ') ?: '—' }}
                </td>
                <td style="text-align:right; white-space: nowrap;">
                    <a href="{{ route('admin.employees.edit', $employee) }}">Edit</a>
                    <form action="{{ route('admin.employees.destroy', $employee) }}" method="POST" style="display:inline-block;margin-left:0.5rem;" onsubmit="return confirm('Delete this employee?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="secondary outline">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5">No employees found.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    {{ $employees->links() }}
@endsection
