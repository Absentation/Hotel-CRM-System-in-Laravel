<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Employee\StoreEmployeeRequest;
use App\Http\Requests\Admin\Employee\UpdateEmployeeRequest;
use App\Models\Employee;
use App\Models\Permission;
use App\Models\Log;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    public function index(): View
    {
        $employees = Employee::query()
            ->with('permissions')
            ->orderBy('name')
            ->paginate(15);

        return view('admin.employees.index', compact('employees'));
    }

    public function create(): View
    {
        $employee = new Employee();
        $permissions = Permission::orderBy('display_name')->get();

        return view('admin.employees.create', compact('employee', 'permissions'));
    }

    public function store(StoreEmployeeRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $employee = Employee::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'role' => $data['role'],
            'password' => $data['password'],
        ]);

        $employee->permissions()->sync($data['permissions'] ?? []);

        $this->logAction('employee_created', $employee->id, [
            'name' => $employee->name,
            'username' => $employee->username,
        ]);

        return redirect()
            ->route('admin.employees.index')
            ->with('success', 'Employee created successfully.');
    }

    public function show(Employee $employee): View
    {
        $employee->load('permissions');

        return view('admin.employees.show', compact('employee'));
    }

    public function edit(Employee $employee): View
    {
        $permissions = Permission::orderBy('display_name')->get();

        return view('admin.employees.edit', compact('employee', 'permissions'));
    }

    public function update(UpdateEmployeeRequest $request, Employee $employee): RedirectResponse
    {
        $data = $request->validated();

        $update = [
            'name' => $data['name'],
            'username' => $data['username'],
            'role' => $data['role'],
        ];

        if (! empty($data['password'])) {
            $update['password'] = $data['password'];
        }

        $employee->update($update);
        $employee->permissions()->sync($data['permissions'] ?? []);

        $this->logAction('employee_updated', $employee->id, [
            'name' => $employee->name,
            'username' => $employee->username,
        ]);

        return redirect()
            ->route('admin.employees.index')
            ->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee): RedirectResponse
    {
        $this->logAction('employee_deleted', $employee->id, [
            'name' => $employee->name,
            'username' => $employee->username,
        ]);

        $employee->permissions()->detach();
        $employee->delete();

        return redirect()
            ->route('admin.employees.index')
            ->with('success', 'Employee removed successfully.');
    }

    public function resetPassword(Employee $employee): RedirectResponse
    {
        $employee->update(['password' => $employee->username]);

        $this->logAction('employee_password_reset', $employee->id, [
            'name' => $employee->name,
            'username' => $employee->username,
        ]);

        return redirect()
            ->route('admin.employees.edit', $employee)
            ->with('success', 'Password reset to username.');
    }

    protected function logAction(string $type, int $employeeId, array $object = []): void
    {
        Log::create([
            'log_type' => $type,
            'object' => json_encode($object),
            'detail' => 'admin_action',
            'employee_id' => auth('admin')->id(),
        ]);
    }
}
