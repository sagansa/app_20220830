<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\VehicleResource;
use App\Http\Resources\VehicleCollection;

class UserVehiclesController extends Controller
{
    public function index(Request $request, User $user): VehicleCollection
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $vehicles = $user
            ->vehicles()
            ->search($search)
            ->latest()
            ->paginate();

        return new VehicleCollection($vehicles);
    }

    public function store(Request $request, User $user): VehicleResource
    {
        $this->authorize('create', Vehicle::class);

        $validated = $request->validate([
            'image' => ['nullable', 'image'],
            'no_register' => ['required', 'max:15', 'string'],
            'type' => ['required', 'in:1,2,3'],
            'store_id' => ['required', 'exists:stores,id'],
            'status' => ['required', 'in:1,2'],
            'notes' => ['nullable', 'max:255', 'string'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $vehicle = $user->vehicles()->create($validated);

        return new VehicleResource($vehicle);
    }
}
