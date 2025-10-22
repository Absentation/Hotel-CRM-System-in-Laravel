<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\AdminAlert;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $employee = auth('employee')->user();

        $activeBookings = Booking::whereNull('check_out_date')->count();
        $arrivalsToday = Booking::whereDate('check_in_date', today())->count();
        $alertsPending = AdminAlert::where('status', 'open')->count();

        return view('employee.dashboard', compact('employee', 'activeBookings', 'arrivalsToday', 'alertsPending'));
    }
}
