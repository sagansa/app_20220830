<?php

namespace App\Http\Controllers\Api;

use App\Models\PaymentType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\FuelServiceResource;
use App\Http\Resources\FuelServiceCollection;

class PaymentTypeFuelServicesController extends Controller
{
    public function index(
        Request $request,
        PaymentType $paymentType
    ): FuelServiceCollection {
        $this->authorize('view', $paymentType);

        $search = $request->get('search', '');

        $fuelServices = $paymentType
            ->fuelServices()
            ->search($search)
            ->latest()
            ->paginate();

        return new FuelServiceCollection($fuelServices);
    }

    public function store(
        Request $request,
        PaymentType $paymentType
    ): FuelServiceResource {
        $this->authorize('create', FuelService::class);

        $validated = $request->validate([
            'image' => ['nullable', 'image'],
            'vehicle_id' => ['required', 'exists:vehicles,id'],
            'fuel_service' => ['required', 'in:1,2'],
            'km' => ['required', 'gt:0', 'numeric'],
            'liter' => ['required', 'gt:0', 'numeric'],
            'amount' => ['required', 'numeric', 'gt:0'],
            'status' => ['required', 'in:1,2,3,4'],
            'notes' => ['nullable', 'max:255', 'string'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $fuelService = $paymentType->fuelServices()->create($validated);

        return new FuelServiceResource($fuelService);
    }
}
