<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\ContractLocation;
use App\Http\Controllers\Controller;
use App\Http\Resources\ContractLocationResource;
use App\Http\Resources\ContractLocationCollection;
use App\Http\Requests\ContractLocationStoreRequest;
use App\Http\Requests\ContractLocationUpdateRequest;

class ContractLocationController extends Controller
{
    public function index(Request $request): ContractLocationCollection
    {
        $this->authorize('view-any', ContractLocation::class);

        $search = $request->get('search', '');

        $contractLocations = ContractLocation::search($search)
            ->latest()
            ->paginate();

        return new ContractLocationCollection($contractLocations);
    }

    public function store(
        ContractLocationStoreRequest $request
    ): ContractLocationResource {
        $this->authorize('create', ContractLocation::class);

        $validated = $request->validated();

        $contractLocation = ContractLocation::create($validated);

        return new ContractLocationResource($contractLocation);
    }

    public function show(
        Request $request,
        ContractLocation $contractLocation
    ): ContractLocationResource {
        $this->authorize('view', $contractLocation);

        return new ContractLocationResource($contractLocation);
    }

    public function update(
        ContractLocationUpdateRequest $request,
        ContractLocation $contractLocation
    ): ContractLocationResource {
        $this->authorize('update', $contractLocation);

        $validated = $request->validated();

        $contractLocation->update($validated);

        return new ContractLocationResource($contractLocation);
    }

    public function destroy(
        Request $request,
        ContractLocation $contractLocation
    ): Response {
        $this->authorize('delete', $contractLocation);

        $contractLocation->delete();

        return response()->noContent();
    }
}
