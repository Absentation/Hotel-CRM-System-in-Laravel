<?php

namespace App\Http\Controllers\Admin\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Inventory\LocationRequest;
use App\Models\Inventory\Location;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class LocationController extends Controller
{
    public function index(): View
    {
        $locations = Location::query()
            ->orderBy('name')
            ->paginate(15);

        return view('admin.inventory.locations.index', compact('locations'));
    }

    public function create(): View
    {
        $location = new Location();

        return view('admin.inventory.locations.create', compact('location'));
    }

    public function store(LocationRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);

        Location::create($data);

        return redirect()
            ->route('admin.inventory.locations.index')
            ->with('success', 'Location created successfully.');
    }

    public function show(Location $location): View
    {
        return view('admin.inventory.locations.show', compact('location'));
    }

    public function edit(Location $location): View
    {
        return view('admin.inventory.locations.edit', compact('location'));
    }

    public function update(LocationRequest $request, Location $location): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);

        $location->update($data);

        return redirect()
            ->route('admin.inventory.locations.index')
            ->with('success', 'Location updated successfully.');
    }

    public function destroy(Location $location): RedirectResponse
    {
        $location->delete();

        return redirect()
            ->route('admin.inventory.locations.index')
            ->with('success', 'Location deleted successfully.');
    }
}
