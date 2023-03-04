<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\MovementAssetResult;
use App\Http\Controllers\Controller;
use App\Http\Resources\MovementAssetResultResource;
use App\Http\Resources\MovementAssetResultCollection;
use App\Http\Requests\MovementAssetResultStoreRequest;
use App\Http\Requests\MovementAssetResultUpdateRequest;

class MovementAssetResultController extends Controller
{
    public function index(Request $request): MovementAssetResultCollection
    {
        $this->authorize('view-any', MovementAssetResult::class);

        $search = $request->get('search', '');

        $movementAssetResults = MovementAssetResult::search($search)
            ->latest()
            ->paginate();

        return new MovementAssetResultCollection($movementAssetResults);
    }

    public function store(
        MovementAssetResultStoreRequest $request
    ): MovementAssetResultResource {
        $this->authorize('create', MovementAssetResult::class);

        $validated = $request->validated();

        $movementAssetResult = MovementAssetResult::create($validated);

        return new MovementAssetResultResource($movementAssetResult);
    }

    public function show(
        Request $request,
        MovementAssetResult $movementAssetResult
    ): MovementAssetResultResource {
        $this->authorize('view', $movementAssetResult);

        return new MovementAssetResultResource($movementAssetResult);
    }

    public function update(
        MovementAssetResultUpdateRequest $request,
        MovementAssetResult $movementAssetResult
    ): MovementAssetResultResource {
        $this->authorize('update', $movementAssetResult);

        $validated = $request->validated();

        $movementAssetResult->update($validated);

        return new MovementAssetResultResource($movementAssetResult);
    }

    public function destroy(
        Request $request,
        MovementAssetResult $movementAssetResult
    ): Response {
        $this->authorize('delete', $movementAssetResult);

        $movementAssetResult->delete();

        return response()->noContent();
    }
}
