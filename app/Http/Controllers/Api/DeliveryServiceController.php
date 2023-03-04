<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\DeliveryService;
use App\Http\Controllers\Controller;
use App\Http\Resources\DeliveryServiceResource;
use App\Http\Resources\DeliveryServiceCollection;
use App\Http\Requests\DeliveryServiceStoreRequest;
use App\Http\Requests\DeliveryServiceUpdateRequest;

class DeliveryServiceController extends Controller
{
    public function index(Request $request): DeliveryServiceCollection
    {
        $this->authorize('view-any', DeliveryService::class);

        $search = $request->get('search', '');

        $deliveryServices = DeliveryService::search($search)
            ->latest()
            ->paginate();

        return new DeliveryServiceCollection($deliveryServices);
    }

    public function store(
        DeliveryServiceStoreRequest $request
    ): DeliveryServiceResource {
        $this->authorize('create', DeliveryService::class);

        $validated = $request->validated();

        $deliveryService = DeliveryService::create($validated);

        return new DeliveryServiceResource($deliveryService);
    }

    public function show(
        Request $request,
        DeliveryService $deliveryService
    ): DeliveryServiceResource {
        $this->authorize('view', $deliveryService);

        return new DeliveryServiceResource($deliveryService);
    }

    public function update(
        DeliveryServiceUpdateRequest $request,
        DeliveryService $deliveryService
    ): DeliveryServiceResource {
        $this->authorize('update', $deliveryService);

        $validated = $request->validated();

        $deliveryService->update($validated);

        return new DeliveryServiceResource($deliveryService);
    }

    public function destroy(
        Request $request,
        DeliveryService $deliveryService
    ): Response {
        $this->authorize('delete', $deliveryService);

        $deliveryService->delete();

        return response()->noContent();
    }
}
