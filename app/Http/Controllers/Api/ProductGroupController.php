<?php

namespace App\Http\Controllers\Api;

use App\Models\ProductGroup;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductGroupResource;
use App\Http\Resources\ProductGroupCollection;
use App\Http\Requests\ProductGroupStoreRequest;
use App\Http\Requests\ProductGroupUpdateRequest;

class ProductGroupController extends Controller
{
    public function index(Request $request): ProductGroupCollection
    {
        $this->authorize('view-any', ProductGroup::class);

        $search = $request->get('search', '');

        $productGroups = ProductGroup::search($search)
            ->latest()
            ->paginate();

        return new ProductGroupCollection($productGroups);
    }

    public function store(
        ProductGroupStoreRequest $request
    ): ProductGroupResource {
        $this->authorize('create', ProductGroup::class);

        $validated = $request->validated();

        $productGroup = ProductGroup::create($validated);

        return new ProductGroupResource($productGroup);
    }

    public function show(
        Request $request,
        ProductGroup $productGroup
    ): ProductGroupResource {
        $this->authorize('view', $productGroup);

        return new ProductGroupResource($productGroup);
    }

    public function update(
        ProductGroupUpdateRequest $request,
        ProductGroup $productGroup
    ): ProductGroupResource {
        $this->authorize('update', $productGroup);

        $validated = $request->validated();

        $productGroup->update($validated);

        return new ProductGroupResource($productGroup);
    }

    public function destroy(
        Request $request,
        ProductGroup $productGroup
    ): Response {
        $this->authorize('delete', $productGroup);

        $productGroup->delete();

        return response()->noContent();
    }
}
