<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminAlert;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AlertController extends Controller
{
    public function index(): View
    {
        $alerts = AdminAlert::with('employee')->latest()->paginate(20);

        return view('admin.alerts.index', compact('alerts'));
    }

    public function show(AdminAlert $alert): View
    {
        return view('admin.alerts.show', compact('alert'));
    }

    public function acknowledge(AdminAlert $alert): RedirectResponse
    {
        $alert->update([
            'status' => 'acknowledged',
            'acknowledged_at' => now(),
        ]);

        return back()->with('success', 'Alert acknowledged.');
    }

    public function resolve(AdminAlert $alert): RedirectResponse
    {
        $alert->update([
            'status' => 'resolved',
            'resolved_at' => now(),
        ]);

        return back()->with('success', 'Alert resolved.');
    }
}
