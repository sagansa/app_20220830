<?php

namespace App\Http\Controllers\Api;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\StoreAssetResource;
use App\Http\Resources\StoreAssetCollection;

class StoreStoreAssetsController extends Controller
{
    public function index(Request $request, Store $store): StoreAssetCollection
    {
        $this->authorize('view', $store);

        $search = $request->get('search', '');

        $storeAssets = $store
            ->storeAssets()
            ->search($search)
            ->latest()
            ->paginate();

        return new StoreAssetCollection($storeAssets);
    }

    public function store(Request $request, Store $store): StoreAssetResource
    {
        $this->authorize('create', StoreAsset::class);

        $validated = $request->validate([
            'status' => ['required', 'max:255'],
            'notes' => ['nullable', 'max:255', 'string'],
        ]);

        $storeAsset = $store->storeAssets()->create($validated);

        return new StoreAssetResource($storeAsset);
    }
}
