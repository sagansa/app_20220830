<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\RemainingStock;
use App\Http\Controllers\Controller;
use App\Http\Resources\RemainingStockResource;
use App\Http\Resources\RemainingStockCollection;
use App\Http\Requests\RemainingStockStoreRequest;
use App\Http\Requests\RemainingStockUpdateRequest;

class RemainingStockController extends Controller
{
    public function index(Request $request): RemainingStockCollection
    {
        $this->authorize('view-any', RemainingStock::class);

        $search = $request->get('search', '');

        $remainingStocks = RemainingStock::search($search)
            ->latest()
            ->paginate();

        return new RemainingStockCollection($remainingStocks);
    }

    public function store(
        RemainingStockStoreRequest $request
    ): RemainingStockResource {
        $this->authorize('create', RemainingStock::class);

        $validated = $request->validated();

        $remainingStock = RemainingStock::create($validated);

        return new RemainingStockResource($remainingStock);
    }

    public function show(
        Request $request,
        RemainingStock $remainingStock
    ): RemainingStockResource {
        $this->authorize('view', $remainingStock);

        return new RemainingStockResource($remainingStock);
    }

    public function update(
        RemainingStockUpdateRequest $request,
        RemainingStock $remainingStock
    ): RemainingStockResource {
        $this->authorize('update', $remainingStock);

        $validated = $request->validated();

        $remainingStock->update($validated);

        return new RemainingStockResource($remainingStock);
    }

    public function destroy(
        Request $request,
        RemainingStock $remainingStock
    ): Response {
        $this->authorize('delete', $remainingStock);

        $remainingStock->delete();

        return response()->noContent();
    }
}
