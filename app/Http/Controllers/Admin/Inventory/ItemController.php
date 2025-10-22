<?php

namespace App\Http\Controllers\Admin\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Inventory\ItemRequest;
use App\Models\Inventory\Category;
use App\Models\Inventory\Item;
use App\Models\Inventory\Location;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ItemController extends Controller
{
    public function index(): View
    {
        $items = Item::query()
            ->with(['category', 'location'])
            ->orderBy('name')
            ->paginate(20);

        return view('admin.inventory.items.index', compact('items'));
    }

    public function create(): View
    {
        $item = new Item([
            'track_quantity' => true,
            'is_active' => true,
        ]);
        $categories = Category::query()->orderBy('name')->pluck('name', 'id');
        $locations = Location::query()->orderBy('name')->pluck('name', 'id');

        return view('admin.inventory.items.create', compact('item', 'categories', 'locations'));
    }

    public function store(ItemRequest $request): RedirectResponse
    {
        $data = $request->validated();

        Item::create($data);

        return redirect()
            ->route('admin.inventory.items.index')
            ->with('success', 'Item created successfully.');
    }

    public function show(Item $item): View
    {
        $item->load([
            'category',
            'location',
            'stocks.location',
            'transactions' => fn ($query) => $query->latest()->take(25)->with('location', 'employee'),
        ]);

        return view('admin.inventory.items.show', compact('item'));
    }

    public function edit(Item $item): View
    {
        $categories = Category::query()->orderBy('name')->pluck('name', 'id');
        $locations = Location::query()->orderBy('name')->pluck('name', 'id');

        return view('admin.inventory.items.edit', compact('item', 'categories', 'locations'));
    }

    public function update(ItemRequest $request, Item $item): RedirectResponse
    {
        $data = $request->validated();

        $item->update($data);

        return redirect()
            ->route('admin.inventory.items.index')
            ->with('success', 'Item updated successfully.');
    }

    public function destroy(Item $item): RedirectResponse
    {
        $item->delete();

        return redirect()
            ->route('admin.inventory.items.index')
            ->with('success', 'Item deleted successfully.');
    }
}
