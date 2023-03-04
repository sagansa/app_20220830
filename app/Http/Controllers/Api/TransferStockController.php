<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\TransferStock;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransferStockResource;
use App\Http\Resources\TransferStockCollection;
use App\Http\Requests\TransferStockStoreRequest;
use App\Http\Requests\TransferStockUpdateRequest;

class TransferStockController extends Controller
{
    public function index(Request $request): TransferStockCollection
    {
        $this->authorize('view-any', TransferStock::class);

        $search = $request->get('search', '');

        $transferStocks = TransferStock::search($search)
            ->latest()
            ->paginate();

        return new TransferStockCollection($transferStocks);
    }

    public function store(
        TransferStockStoreRequest $request
    ): TransferStockResource {
        $this->authorize('create', TransferStock::class);

        $validated = $request->validated();

        $transferStock = TransferStock::create($validated);

        return new TransferStockResource($transferStock);
    }

    public function show(
        Request $request,
        TransferStock $transferStock
    ): TransferStockResource {
        $this->authorize('view', $transferStock);

        return new TransferStockResource($transferStock);
    }

    public function update(
        TransferStockUpdateRequest $request,
        TransferStock $transferStock
    ): TransferStockResource {
        $this->authorize('update', $transferStock);

        $validated = $request->validated();

        $transferStock->update($validated);

        return new TransferStockResource($transferStock);
    }

    public function destroy(
        Request $request,
        TransferStock $transferStock
    ): Response {
        $this->authorize('delete', $transferStock);

        $transferStock->delete();

        return response()->noContent();
    }
}
