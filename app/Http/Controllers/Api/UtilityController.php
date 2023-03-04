<?php

namespace App\Http\Controllers\Api;

use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\UtilityResource;
use App\Http\Resources\UtilityCollection;
use App\Http\Requests\UtilityStoreRequest;
use App\Http\Requests\UtilityUpdateRequest;

class UtilityController extends Controller
{
    public function index(Request $request): UtilityCollection
    {
        $this->authorize('view-any', Utility::class);

        $search = $request->get('search', '');

        $utilities = Utility::search($search)
            ->latest()
            ->paginate();

        return new UtilityCollection($utilities);
    }

    public function store(UtilityStoreRequest $request): UtilityResource
    {
        $this->authorize('create', Utility::class);

        $validated = $request->validated();

        $utility = Utility::create($validated);

        return new UtilityResource($utility);
    }

    public function show(Request $request, Utility $utility): UtilityResource
    {
        $this->authorize('view', $utility);

        return new UtilityResource($utility);
    }

    public function update(
        UtilityUpdateRequest $request,
        Utility $utility
    ): UtilityResource {
        $this->authorize('update', $utility);

        $validated = $request->validated();

        $utility->update($validated);

        return new UtilityResource($utility);
    }

    public function destroy(Request $request, Utility $utility): Response
    {
        $this->authorize('delete', $utility);

        $utility->delete();

        return response()->noContent();
    }
}
