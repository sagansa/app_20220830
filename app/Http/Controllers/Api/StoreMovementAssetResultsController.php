<?php

namespace App\Http\Controllers\Api;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MovementAssetResultResource;
use App\Http\Resources\MovementAssetResultCollection;

class StoreMovementAssetResultsController extends Controller
{
    public function index(
        Request $request,
        Store $store
    ): MovementAssetResultCollection {
        $this->authorize('view', $store);

        $search = $request->get('search', '');

        $movementAssetResults = $store
            ->movementAssetResults()
            ->search($search)
            ->latest()
            ->paginate();

        return new MovementAssetResultCollection($movementAssetResults);
    }

    public function store(
        Request $request,
        Store $store
    ): MovementAssetResultResource {
        $this->authorize('create', MovementAssetResult::class);

        $validated = $request->validate([
            'date' => ['required', 'date'],
            'status' => ['required', 'max:255'],
            'notes' => ['nullable', 'max:255', 'string'],
            'user_id' => ['nullable', 'exists:users,id'],
        ]);

        $movementAssetResult = $store
            ->movementAssetResults()
            ->create($validated);

        return new MovementAssetResultResource($movementAssetResult);
    }
}
