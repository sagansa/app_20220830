<?php

namespace App\Http\Controllers\Api;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransferStockResource;
use App\Http\Resources\TransferStockCollection;

class StoreTransferStocksController extends Controller
{
    public function index(
        Request $request,
        Store $store
    ): TransferStockCollection {
        $this->authorize('view', $store);

        $search = $request->get('search', '');

        $transferStocks = $store
            ->toTransferStocks()
            ->search($search)
            ->latest()
            ->paginate();

        return new TransferStockCollection($transferStocks);
    }

    public function store(Request $request, Store $store): TransferStockResource
    {
        $this->authorize('create', TransferStock::class);

        $validated = $request->validate([
            'date' => ['required', 'date'],
            'status' => ['required', 'in:1,2,3,4'],
            'received_by_id' => ['required', 'exists:users,id'],
            'sent_by_id' => ['required', 'exists:users,id'],
            'approved_by_id' => ['nullable', 'exists:users,id'],
            'notes' => ['nullable', 'max:255', 'string'],
        ]);

        $transferStock = $store->toTransferStocks()->create($validated);

        return new TransferStockResource($transferStock);
    }
}
