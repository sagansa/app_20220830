<?php

namespace App\Http\Controllers\Api;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\VehicleResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\VehicleCollection;
use App\Http\Requests\VehicleStoreRequest;
use App\Http\Requests\VehicleUpdateRequest;

class VehicleController extends Controller
{
    public function index(Request $request): VehicleCollection
    {
        $this->authorize('view-any', Vehicle::class);

        $search = $request->get('search', '');

        $vehicles = Vehicle::search($search)
            ->latest()
            ->paginate();

        return new VehicleCollection($vehicles);
    }

    public function store(VehicleStoreRequest $request): VehicleResource
    {
        $this->authorize('create', Vehicle::class);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $vehicle = Vehicle::create($validated);

        return new VehicleResource($vehicle);
    }

    public function show(Request $request, Vehicle $vehicle): VehicleResource
    {
        $this->authorize('view', $vehicle);

        return new VehicleResource($vehicle);
    }

    public function update(
        VehicleUpdateRequest $request,
        Vehicle $vehicle
    ): VehicleResource {
        $this->authorize('update', $vehicle);

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($vehicle->image) {
                Storage::delete($vehicle->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        $vehicle->update($validated);

        return new VehicleResource($vehicle);
    }

    public function destroy(Request $request, Vehicle $vehicle): Response
    {
        $this->authorize('delete', $vehicle);

        if ($vehicle->image) {
            Storage::delete($vehicle->image);
        }

        $vehicle->delete();

        return response()->noContent();
    }
}
