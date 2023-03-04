<?php

namespace App\Http\Controllers\Api;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\RemainingStockResource;
use App\Http\Resources\RemainingStockCollection;

class StoreRemainingStocksController extends Controller
{
    public function index(
        Request $request,
        Store $store
    ): RemainingStockCollection {
        $this->authorize('view', $store);

        $search = $request->get('search', '');

        $remainingStocks = $store
            ->remainingStocks()
            ->search($search)
            ->latest()
            ->paginate();

        return new RemainingStockCollection($remainingStocks);
    }

    public function store(
        Request $request,
        Store $store
    ): RemainingStockResource {
        $this->authorize('create', RemainingStock::class);

        $validated = $request->validate([
            'date' => ['required', 'date'],
            'status' => ['required', 'in:1,2,3,4'],
            'notes' => ['nullable', 'max:255', 'string'],
            'created_by_id' => ['nullable', 'exists:users,id'],
            'approved_by_id' => ['nullable', 'exists:users,id'],
        ]);

        $remainingStock = $store->remainingStocks()->create($validated);

        return new RemainingStockResource($remainingStock);
    }
}
