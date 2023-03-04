<?php

namespace App\Http\Controllers\Api;

use App\Models\Production;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductionToResource;
use App\Http\Resources\ProductionToCollection;

class ProductionProductionTosController extends Controller
{
    public function index(
        Request $request,
        Production $production
    ): ProductionToCollection {
        $this->authorize('view', $production);

        $search = $request->get('search', '');

        $productionTos = $production
            ->productionTos()
            ->search($search)
            ->latest()
            ->paginate();

        return new ProductionToCollection($productionTos);
    }

    public function store(
        Request $request,
        Production $production
    ): ProductionToResource {
        $this->authorize('create', ProductionTo::class);

        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'numeric', 'gt:0'],
        ]);

        $productionTo = $production->productionTos()->create($validated);

        return new ProductionToResource($productionTo);
    }
}
