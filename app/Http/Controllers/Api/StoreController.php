<?php

namespace App\Http\Controllers\Api;

use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\StoreResource;
use App\Http\Resources\StoreCollection;
use App\Http\Requests\StoreStoreRequest;
use App\Http\Requests\StoreUpdateRequest;

class StoreController extends Controller
{
    public function index(Request $request): StoreCollection
    {
        $this->authorize('view-any', Store::class);

        $search = $request->get('search', '');

        $stores = Store::search($search)
            ->latest()
            ->paginate();

        return new StoreCollection($stores);
    }

    public function store(StoreStoreRequest $request): StoreResource
    {
        $this->authorize('create', Store::class);

        $validated = $request->validated();

        $store = Store::create($validated);

        return new StoreResource($store);
    }

    public function show(Request $request, Store $store): StoreResource
    {
        $this->authorize('view', $store);

        return new StoreResource($store);
    }

    public function update(
        StoreUpdateRequest $request,
        Store $store
    ): StoreResource {
        $this->authorize('update', $store);

        $validated = $request->validated();

        $store->update($validated);

        return new StoreResource($store);
    }

    public function destroy(Request $request, Store $store): Response
    {
        $this->authorize('delete', $store);

        $store->delete();

        return response()->noContent();
    }
}
