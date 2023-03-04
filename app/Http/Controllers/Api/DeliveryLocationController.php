<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\DeliveryLocation;
use App\Http\Controllers\Controller;
use App\Http\Resources\DeliveryLocationResource;
use App\Http\Resources\DeliveryLocationCollection;
use App\Http\Requests\DeliveryLocationStoreRequest;
use App\Http\Requests\DeliveryLocationUpdateRequest;

class DeliveryLocationController extends Controller
{
    public function index(Request $request): DeliveryLocationCollection
    {
        $this->authorize('view-any', DeliveryLocation::class);

        $search = $request->get('search', '');

        $deliveryLocations = DeliveryLocation::search($search)
            ->latest()
            ->paginate();

        return new DeliveryLocationCollection($deliveryLocations);
    }

    public function store(
        DeliveryLocationStoreRequest $request
    ): DeliveryLocationResource {
        $this->authorize('create', DeliveryLocation::class);

        $validated = $request->validated();

        $deliveryLocation = DeliveryLocation::create($validated);

        return new DeliveryLocationResource($deliveryLocation);
    }

    public function show(
        Request $request,
        DeliveryLocation $deliveryLocation
    ): DeliveryLocationResource {
        $this->authorize('view', $deliveryLocation);

        return new DeliveryLocationResource($deliveryLocation);
    }

    public function update(
        DeliveryLocationUpdateRequest $request,
        DeliveryLocation $deliveryLocation
    ): DeliveryLocationResource {
        $this->authorize('update', $deliveryLocation);

        $validated = $request->validated();

        $deliveryLocation->update($validated);

        return new DeliveryLocationResource($deliveryLocation);
    }

    public function destroy(
        Request $request,
        DeliveryLocation $deliveryLocation
    ): Response {
        $this->authorize('delete', $deliveryLocation);

        $deliveryLocation->delete();

        return response()->noContent();
    }
}
