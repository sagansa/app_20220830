<?php

namespace App\Http\Controllers\Api;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\RequestPurchaseResource;
use App\Http\Resources\RequestPurchaseCollection;

class StoreRequestPurchasesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Store $store
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Store $store)
    {
        $this->authorize('view', $store);

        $search = $request->get('search', '');

        $requestPurchases = $store
            ->requestPurchases()
            ->search($search)
            ->latest()
            ->paginate();

        return new RequestPurchaseCollection($requestPurchases);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Store $store
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Store $store)
    {
        $this->authorize('create', RequestPurchase::class);

        $validated = $request->validate([
            'date' => ['required', 'date'],
            'status' => ['required', 'max:255'],
            'user_id' => ['nullable', 'exists:users,id'],
        ]);

        $requestPurchase = $store->requestPurchases()->create($validated);

        return new RequestPurchaseResource($requestPurchase);
    }
}
