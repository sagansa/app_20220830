<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\FuelServiceResource;
use App\Http\Resources\FuelServiceCollection;

class UserFuelServicesController extends Controller
{
    public function index(Request $request, User $user): FuelServiceCollection
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $fuelServices = $user
            ->fuelServicesCreated()
            ->search($search)
            ->latest()
            ->paginate();

        return new FuelServiceCollection($fuelServices);
    }

    public function store(Request $request, User $user): FuelServiceResource
    {
        $this->authorize('create', FuelService::class);

        $validated = $request->validate([
            'image' => ['nullable', 'image'],
            'vehicle_id' => ['required', 'exists:vehicles,id'],
            'fuel_service' => ['required', 'in:1,2'],
            'payment_type_id' => ['required', 'exists:payment_types,id'],
            'km' => ['required', 'gt:0', 'numeric'],
            'liter' => ['required', 'gt:0', 'numeric'],
            'amount' => ['required', 'numeric', 'gt:0'],
            'status' => ['required', 'in:1,2,3,4'],
            'notes' => ['nullable', 'max:255', 'string'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $fuelService = $user->fuelServicesCreated()->create($validated);

        return new FuelServiceResource($fuelService);
    }
}
