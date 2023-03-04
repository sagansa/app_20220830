<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransferStockResource;
use App\Http\Resources\TransferStockCollection;

class UserTransferStocksController extends Controller
{
    public function index(Request $request, User $user): TransferStockCollection
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $transferStocks = $user
            ->transferStocksReceived()
            ->search($search)
            ->latest()
            ->paginate();

        return new TransferStockCollection($transferStocks);
    }

    public function store(Request $request, User $user): TransferStockResource
    {
        $this->authorize('create', TransferStock::class);

        $validated = $request->validate([
            'date' => ['required', 'date'],
            'from_store_id' => ['required', 'exists:stores,id'],
            'to_store_id' => ['required', 'exists:stores,id'],
            'status' => ['required', 'in:1,2,3,4'],
            'notes' => ['nullable', 'max:255', 'string'],
        ]);

        $transferStock = $user->transferStocksReceived()->create($validated);

        return new TransferStockResource($transferStock);
    }
}
