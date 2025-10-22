<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Reports\HotelReportService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(private readonly HotelReportService $reports)
    {
    }

    public function index(): View
    {
        $bookingSummary = $this->reports->bookingSummary();
        $paymentSummary = $this->reports->paymentSummary();
        $inventoryAlerts = $this->reports->inventoryAlerts();

        return view('admin.dashboard', compact('bookingSummary', 'paymentSummary', 'inventoryAlerts'));
    }
}
