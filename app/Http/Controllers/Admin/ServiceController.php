<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Service\StoreServiceRequest;
use App\Http\Requests\Admin\Service\UpdateServiceRequest;
use App\Models\AdditionalService;
use App\Models\Log;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        $services = AdditionalService::orderBy('name')->paginate(15);

        return view('admin.services.index', compact('services'));
    }

    public function create(): View
    {
        $service = new AdditionalService();

        return view('admin.services.create', compact('service'));
    }

    public function store(StoreServiceRequest $request): RedirectResponse
    {
        $service = AdditionalService::create($request->validated());

        $this->logAction('service_created', $service->id, $service->toArray());

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Service created successfully.');
    }

    public function show(AdditionalService $service): View
    {
        return view('admin.services.show', compact('service'));
    }

    public function edit(AdditionalService $service): View
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(UpdateServiceRequest $request, AdditionalService $service): RedirectResponse
    {
        $service->update($request->validated());

        $this->logAction('service_updated', $service->id, $service->toArray());

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Service updated successfully.');
    }

    public function destroy(AdditionalService $service): RedirectResponse
    {
        $this->logAction('service_deleted', $service->id, $service->toArray());
        $service->delete();

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Service deleted.');
    }

    protected function logAction(string $type, int $serviceId, array $object = []): void
    {
        Log::create([
            'log_type' => $type,
            'object' => json_encode(['service_id' => $serviceId, ...$object]),
            'detail' => 'admin_action',
            'employee_id' => auth('admin')->id(),
        ]);
    }
}
