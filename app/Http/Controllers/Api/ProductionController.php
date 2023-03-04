<?php

namespace App\Http\Controllers\Api;

use App\Models\Production;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductionResource;
use App\Http\Resources\ProductionCollection;
use App\Http\Requests\ProductionStoreRequest;
use App\Http\Requests\ProductionUpdateRequest;

class ProductionController extends Controller
{
    public function index(Request $request): ProductionCollection
    {
        $this->authorize('view-any', Production::class);

        $search = $request->get('search', '');

        $productions = Production::search($search)
            ->latest()
            ->paginate();

        return new ProductionCollection($productions);
    }

    public function store(ProductionStoreRequest $request): ProductionResource
    {
        $this->authorize('create', Production::class);

        $validated = $request->validated();

        $production = Production::create($validated);

        return new ProductionResource($production);
    }

    public function show(
        Request $request,
        Production $production
    ): ProductionResource {
        $this->authorize('view', $production);

        return new ProductionResource($production);
    }

    public function update(
        ProductionUpdateRequest $request,
        Production $production
    ): ProductionResource {
        $this->authorize('update', $production);

        $validated = $request->validated();

        $production->update($validated);

        return new ProductionResource($production);
    }

    public function destroy(Request $request, Production $production): Response
    {
        $this->authorize('delete', $production);

        $production->delete();

        return response()->noContent();
    }
}
