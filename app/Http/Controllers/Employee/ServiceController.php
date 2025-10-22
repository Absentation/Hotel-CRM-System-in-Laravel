<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Service\StoreServiceRequest;
use App\Http\Requests\Admin\Service\UpdateServiceRequest;
use App\Models\AdditionalService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        $services = AdditionalService::orderBy('name')->paginate(15);

        return view('employee.services.index', compact('services'));
    }

    public function create(): View
    {
        return view('employee.services.create', ['service' => new AdditionalService()]);
    }

    public function store(StoreServiceRequest $request): RedirectResponse
    {
        AdditionalService::create($request->validated());

        return redirect()->route('employee.services.index')->with('success', 'Service created successfully.');
    }

    public function edit(AdditionalService $service): View
    {
        return view('employee.services.edit', compact('service'));
    }

    public function update(UpdateServiceRequest $request, AdditionalService $service): RedirectResponse
    {
        $service->update($request->validated());

        return redirect()->route('employee.services.index')->with('success', 'Service updated successfully.');
    }

    public function destroy(AdditionalService $service): RedirectResponse
    {
        $service->delete();

        return redirect()->route('employee.services.index')->with('success', 'Service deleted successfully.');
    }
}
