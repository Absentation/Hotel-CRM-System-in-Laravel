<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\AdminAlert;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AlertController extends Controller
{
    public function index(): View
    {
        $alerts = AdminAlert::where('employee_id', auth('employee')->id())
            ->latest()
            ->paginate(15);

        return view('employee.alerts.index', compact('alerts'));
    }

    public function create(): View
    {
        return view('employee.alerts.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
        ]);

        AdminAlert::create([
            'employee_id' => auth('employee')->id(),
            'subject' => $data['subject'],
            'message' => $data['message'],
        ]);

        return redirect()->route('employee.alerts.index')->with('success', 'Alert sent to administrators.');
    }
}
