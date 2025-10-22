<?php

namespace App\Services\Reports;

use App\Models\Booking;
use App\Models\Inventory\Item;
use App\Models\Inventory\Transaction;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class HotelReportService
{
    public function bookingSummary(): array
    {
        $today = Carbon::today();
        $sixMonthsAgo = $today->copy()->subMonths(5)->startOfMonth();

        $bookingsTotal = Booking::count();
        $bookingsActive = Booking::whereNull('check_out_date')->count();
        $bookingsToday = Booking::whereDate('check_in_date', $today)->count();
        $bookingsUpcoming = Booking::whereDate('check_in_date', '>', $today)->count();

        $periodExpression = $this->monthlyFormatExpression('booking_date');

        $bookingsByMonth = Booking::selectRaw("{$periodExpression} as period, COUNT(*) as total")
            ->where('booking_date', '>=', $sixMonthsAgo)
            ->groupBy('period')
            ->orderBy('period')
            ->get()
            ->map(fn ($row) => [
                'period' => $this->formatPeriodLabel($row->period),
                'total' => (int) $row->total,
            ]);

        return [
            'totals' => [
                'overall' => $bookingsTotal,
                'active' => $bookingsActive,
                'today' => $bookingsToday,
                'upcoming' => $bookingsUpcoming,
            ],
            'by_month' => $bookingsByMonth,
        ];
    }

    public function paymentSummary(): array
    {
        $today = Carbon::today();
        $sixMonthsAgo = $today->copy()->subMonths(5)->startOfMonth();

        $totalRevenue = Payment::sum('amount');
        $monthRevenue = Payment::whereBetween('pay_date', [$today->copy()->startOfMonth(), $today->copy()->endOfMonth()])->sum('amount');
        $yearRevenue = Payment::whereBetween('pay_date', [$today->copy()->startOfYear(), $today->copy()->endOfYear()])->sum('amount');

        $periodExpression = $this->monthlyFormatExpression('pay_date');

        $revenueByMonth = Payment::selectRaw("{$periodExpression} as period, SUM(amount) as total")
            ->where('pay_date', '>=', $sixMonthsAgo)
            ->groupBy('period')
            ->orderBy('period')
            ->get()
            ->map(fn ($row) => [
                'period' => $this->formatPeriodLabel($row->period),
                'total' => (float) $row->total,
            ]);

        return [
            'totals' => [
                'overall' => (float) $totalRevenue,
                'this_month' => (float) $monthRevenue,
                'this_year' => (float) $yearRevenue,
            ],
            'by_month' => $revenueByMonth,
        ];
    }

    public function inventoryAlerts(): array
    {
        $lowStockItems = Item::query()
            ->where('track_quantity', true)
            ->where('is_active', true)
            ->withSum('stocks as quantity_on_hand', 'quantity_on_hand')
            ->with('category')
            ->get()
            ->filter(fn ($item) => $item->reorder_level > 0 && ($item->quantity_on_hand ?? 0) <= $item->reorder_level)
            ->sortByDesc(fn ($item) => $item->reorder_level - ($item->quantity_on_hand ?? 0))
            ->take(10)
            ->values()
            ->map(fn ($item) => [
                'name' => $item->name,
                'category' => $item->category?->name,
                'on_hand' => (float) ($item->quantity_on_hand ?? 0),
                'reorder_level' => (int) $item->reorder_level,
            ]);

        $recentTransactions = Transaction::query()
            ->with(['item', 'location', 'employee'])
            ->latest('occurred_at')
            ->take(10)
            ->get()
            ->map(fn ($transaction) => [
                'item' => $transaction->item?->name,
                'type' => $transaction->transaction_type,
                'quantity' => (float) $transaction->quantity,
                'occurred_at' => $transaction->occurred_at,
                'location' => $transaction->location?->name,
                'employee' => $transaction->employee?->name,
            ]);

        return [
            'low_stock' => $lowStockItems,
            'recent_transactions' => $recentTransactions,
        ];
    }

    protected function monthlyFormatExpression(string $column): string
    {
        return match (DB::getDriverName()) {
            'sqlite' => "strftime('%Y-%m', {$column})",
            'mysql' => "DATE_FORMAT({$column}, '%Y-%m')",
            'pgsql' => "TO_CHAR({$column}, 'YYYY-MM')",
            default => "DATE_FORMAT({$column}, '%Y-%m')",
        };
    }

    protected function formatPeriodLabel(string $period): string
    {
        try {
            return Carbon::createFromFormat('Y-m', $period)->format('M Y');
        } catch (\Throwable $e) {
            return $period;
        }
    }
}
