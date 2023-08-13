<?php

namespace App\Http\Controllers\Api;

use App\Models\Location;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ContractLocationResource;
use App\Http\Resources\ContractLocationCollection;

class LocationContractLocationsController extends Controller
{
    public function index(
        Request $request,
        Location $location
    ): ContractLocationCollection {
        $this->authorize('view', $location);

        $search = $request->get('search', '');

        $contractLocations = $location
            ->contractLocations()
            ->search($search)
            ->latest()
            ->paginate();

        return new ContractLocationCollection($contractLocations);
    }

    public function store(
        Request $request,
        Location $location
    ): ContractLocationResource {
        $this->authorize('create', ContractLocation::class);

        $validated = $request->validate([
            'from_date' => ['required', 'date'],
            'until_date' => ['required', 'date'],
            'nominal_contract' => ['required', 'max:255'],
        ]);

        $contractLocation = $location->contractLocations()->create($validated);

        return new ContractLocationResource($contractLocation);
    }
}
