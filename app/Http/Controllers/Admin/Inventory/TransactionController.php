<?php

namespace App\Http\Controllers\Admin\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Inventory\TransactionRequest;
use App\Models\Inventory\Item;
use App\Models\Inventory\Location;
use App\Models\Inventory\Stock;
use App\Models\Inventory\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function index(): View
    {
        $transactions = Transaction::query()
            ->with(['item', 'location', 'employee'])
            ->latest('occurred_at')
            ->paginate(25);

        return view('admin.inventory.transactions.index', compact('transactions'));
    }

    public function create(): View
    {
        $items = Item::query()->orderBy('name')->with('location')->get();
        $locations = Location::query()->orderBy('name')->get();
        $transactionTypes = [
            'receipt' => 'Receipt (Add stock)',
            'issue' => 'Issue (Remove stock)',
            'adjustment_in' => 'Adjustment Increase',
            'adjustment_out' => 'Adjustment Decrease',
            'waste' => 'Waste / Spoilage',
        ];

        return view('admin.inventory.transactions.create', compact('items', 'locations', 'transactionTypes'));
    }

    public function store(TransactionRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $item = Item::query()->with('location')->findOrFail($data['item_id']);
        $locationId = $data['location_id'] ?? $item->location_id;

        if (! $locationId) {
            throw ValidationException::withMessages([
                'location_id' => 'Please select a storage location for this item.',
            ]);
        }

        $unitCost = $data['unit_cost'] ?? $item->unit_cost;
        $quantity = $data['quantity'];
        $transactionType = $data['transaction_type'];

        $negativeTypes = ['issue', 'adjustment_out', 'waste'];
        $delta = in_array($transactionType, $negativeTypes, true) ? -1 * $quantity : $quantity;

        $totalCost = $data['total_cost'] ?? ($unitCost !== null ? round(abs($delta) * $unitCost, 2) : null);

        DB::transaction(function () use ($item, $locationId, $delta, $data, $unitCost, $totalCost, $request, $transactionType) {
            $stock = Stock::query()
                ->lockForUpdate()
                ->firstOrCreate(
                    ['item_id' => $item->id, 'location_id' => $locationId],
                    [
                        'quantity_on_hand' => 0,
                        'quantity_reserved' => 0,
                        'quantity_available' => 0,
                    ]
                );

            $stock->quantity_on_hand += $delta;
            $stock->quantity_available = $stock->quantity_on_hand - $stock->quantity_reserved;
            if ($stock->quantity_available < 0) {
                $stock->quantity_available = 0;
            }
            $stock->last_audited_at = now();
            $stock->save();

            Transaction::create([
                'item_id' => $item->id,
                'location_id' => $locationId,
                'employee_id' => $request->user('admin')?->id,
                'transaction_type' => $transactionType,
                'quantity' => $delta,
                'unit_cost' => $unitCost,
                'total_cost' => $totalCost,
                'occurred_at' => $data['occurred_at'],
                'notes' => $data['notes'] ?? null,
                'meta' => $data['meta'] ?? null,
            ]);
        });

        return redirect()
            ->route('admin.inventory.transactions.index')
            ->with('success', 'Inventory transaction recorded successfully.');
    }

    public function show(Transaction $transaction): View
    {
        $transaction->load(['item', 'location', 'employee']);

        return view('admin.inventory.transactions.show', compact('transaction'));
    }

    public function edit(): never
    {
        abort(404);
    }

    public function update(): never
    {
        abort(404);
    }

    public function destroy(): never
    {
        abort(404);
    }
}
