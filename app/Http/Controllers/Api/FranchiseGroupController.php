<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\FranchiseGroup;
use App\Http\Controllers\Controller;
use App\Http\Resources\FranchiseGroupResource;
use App\Http\Resources\FranchiseGroupCollection;
use App\Http\Requests\FranchiseGroupStoreRequest;
use App\Http\Requests\FranchiseGroupUpdateRequest;

class FranchiseGroupController extends Controller
{
    public function index(Request $request): FranchiseGroupCollection
    {
        $this->authorize('view-any', FranchiseGroup::class);

        $search = $request->get('search', '');

        $franchiseGroups = FranchiseGroup::search($search)
            ->latest()
            ->paginate();

        return new FranchiseGroupCollection($franchiseGroups);
    }

    public function store(
        FranchiseGroupStoreRequest $request
    ): FranchiseGroupResource {
        $this->authorize('create', FranchiseGroup::class);

        $validated = $request->validated();

        $franchiseGroup = FranchiseGroup::create($validated);

        return new FranchiseGroupResource($franchiseGroup);
    }

    public function show(
        Request $request,
        FranchiseGroup $franchiseGroup
    ): FranchiseGroupResource {
        $this->authorize('view', $franchiseGroup);

        return new FranchiseGroupResource($franchiseGroup);
    }

    public function update(
        FranchiseGroupUpdateRequest $request,
        FranchiseGroup $franchiseGroup
    ): FranchiseGroupResource {
        $this->authorize('update', $franchiseGroup);

        $validated = $request->validated();

        $franchiseGroup->update($validated);

        return new FranchiseGroupResource($franchiseGroup);
    }

    public function destroy(
        Request $request,
        FranchiseGroup $franchiseGroup
    ): Response {
        $this->authorize('delete', $franchiseGroup);

        $franchiseGroup->delete();

        return response()->noContent();
    }
}
