<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\RemainingStockResource;
use App\Http\Resources\RemainingStockCollection;

class UserRemainingStocksController extends Controller
{
    public function index(
        Request $request,
        User $user
    ): RemainingStockCollection {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $remainingStocks = $user
            ->remainingStocksApproved()
            ->search($search)
            ->latest()
            ->paginate();

        return new RemainingStockCollection($remainingStocks);
    }

    public function store(Request $request, User $user): RemainingStockResource
    {
        $this->authorize('create', RemainingStock::class);

        $validated = $request->validate([
            'date' => ['required', 'date'],
            'store_id' => ['required', 'exists:stores,id'],
            'status' => ['required', 'in:1,2,3,4'],
            'notes' => ['nullable', 'max:255', 'string'],
        ]);

        $remainingStock = $user->remainingStocksApproved()->create($validated);

        return new RemainingStockResource($remainingStock);
    }
}
