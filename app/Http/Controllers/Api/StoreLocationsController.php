<?php

namespace App\Http\Controllers\Api;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\LocationResource;
use App\Http\Resources\LocationCollection;

class StoreLocationsController extends Controller
{
    public function index(Request $request, Store $store): LocationCollection
    {
        $this->authorize('view', $store);

        $search = $request->get('search', '');

        $locations = $store
            ->locations()
            ->search($search)
            ->latest()
            ->paginate();

        return new LocationCollection($locations);
    }

    public function store(Request $request, Store $store): LocationResource
    {
        $this->authorize('create', Location::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'address' => ['required', 'max:255', 'string'],
            'contact_person_name' => ['required', 'max:255', 'string'],
            'contact_person_number' => ['required', 'max:255', 'string'],
            'village_id' => ['nullable', 'exists:villages,id'],
            'codepos' => ['nullable', 'numeric'],
            'province_id' => ['nullable', 'exists:provinces,id'],
            'regency_id' => ['nullable', 'exists:regencies,id'],
            'district_id' => ['nullable', 'exists:districts,id'],
        ]);

        $location = $store->locations()->create($validated);

        return new LocationResource($location);
    }
}
