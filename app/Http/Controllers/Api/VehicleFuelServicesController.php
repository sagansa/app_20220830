<?php

namespace App\Http\Controllers\Api;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\FuelServiceResource;
use App\Http\Resources\FuelServiceCollection;

class VehicleFuelServicesController extends Controller
{
    public function index(
        Request $request,
        Vehicle $vehicle
    ): FuelServiceCollection {
        $this->authorize('view', $vehicle);

        $search = $request->get('search', '');

        $fuelServices = $vehicle
            ->fuelServices()
            ->search($search)
            ->latest()
            ->paginate();

        return new FuelServiceCollection($fuelServices);
    }

    public function store(
        Request $request,
        Vehicle $vehicle
    ): FuelServiceResource {
        $this->authorize('create', FuelService::class);

        $validated = $request->validate([
            'image' => ['nullable', 'image'],
            'fuel_service' => ['required', 'in:1,2'],
            'payment_type_id' => ['required', 'exists:payment_types,id'],
            'km' => ['required', 'gt:0'],
            'liter' => ['required', 'gt:0'],
            'amount' => ['required', 'numeric', 'gt:0'],
            'status' => ['required', 'in:1,2,3,4'],
            'notes' => ['nullable', 'max:255', 'string'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $fuelService = $vehicle->fuelServices()->create($validated);

        return new FuelServiceResource($fuelService);
    }
}
