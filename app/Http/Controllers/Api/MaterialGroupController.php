<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\MaterialGroup;
use App\Http\Controllers\Controller;
use App\Http\Resources\MaterialGroupResource;
use App\Http\Resources\MaterialGroupCollection;
use App\Http\Requests\MaterialGroupStoreRequest;
use App\Http\Requests\MaterialGroupUpdateRequest;

class MaterialGroupController extends Controller
{
    public function index(Request $request): MaterialGroupCollection
    {
        $this->authorize('view-any', MaterialGroup::class);

        $search = $request->get('search', '');

        $materialGroups = MaterialGroup::search($search)
            ->latest()
            ->paginate();

        return new MaterialGroupCollection($materialGroups);
    }

    public function store(
        MaterialGroupStoreRequest $request
    ): MaterialGroupResource {
        $this->authorize('create', MaterialGroup::class);

        $validated = $request->validated();

        $materialGroup = MaterialGroup::create($validated);

        return new MaterialGroupResource($materialGroup);
    }

    public function show(
        Request $request,
        MaterialGroup $materialGroup
    ): MaterialGroupResource {
        $this->authorize('view', $materialGroup);

        return new MaterialGroupResource($materialGroup);
    }

    public function update(
        MaterialGroupUpdateRequest $request,
        MaterialGroup $materialGroup
    ): MaterialGroupResource {
        $this->authorize('update', $materialGroup);

        $validated = $request->validated();

        $materialGroup->update($validated);

        return new MaterialGroupResource($materialGroup);
    }

    public function destroy(
        Request $request,
        MaterialGroup $materialGroup
    ): Response {
        $this->authorize('delete', $materialGroup);

        $materialGroup->delete();

        return response()->noContent();
    }
}
