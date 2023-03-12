<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DeliveryLocationResource;
use App\Http\Resources\DeliveryLocationCollection;

class UserDeliveryLocationsController extends Controller
{
    public function index(
        Request $request,
        User $user
    ): DeliveryLocationCollection {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $deliveryLocations = $user
            ->deliveryLocations()
            ->search($search)
            ->latest()
            ->paginate();

        return new DeliveryLocationCollection($deliveryLocations);
    }

    public function store(
        Request $request,
        User $user
    ): DeliveryLocationResource {
        $this->authorize('create', DeliveryLocation::class);

        $validated = $request->validate([
            'label' => ['required', 'max:255', 'string'],
            'contact_name' => ['required', 'max:255', 'string'],
            'contact_number' => ['required', 'max:255', 'string'],
            'Address' => ['required', 'max:255', 'string'],
            'village_id' => ['nullable', 'exists:villages,id'],
            'province_id' => ['nullable', 'exists:provinces,id'],
            'regency_id' => ['nullable', 'exists:regencies,id'],
            'district_id' => ['nullable', 'exists:districts,id'],
        ]);

        $deliveryLocation = $user->deliveryLocations()->create($validated);

        return new DeliveryLocationResource($deliveryLocation);
    }
}
