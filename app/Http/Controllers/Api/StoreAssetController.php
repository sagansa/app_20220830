<?php

namespace App\Http\Controllers\Api;

use App\Models\StoreAsset;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\StoreAssetResource;
use App\Http\Resources\StoreAssetCollection;
use App\Http\Requests\StoreAssetStoreRequest;
use App\Http\Requests\StoreAssetUpdateRequest;

class StoreAssetController extends Controller
{
    public function index(Request $request): StoreAssetCollection
    {
        $this->authorize('view-any', StoreAsset::class);

        $search = $request->get('search', '');

        $storeAssets = StoreAsset::search($search)
            ->latest()
            ->paginate();

        return new StoreAssetCollection($storeAssets);
    }

    public function store(StoreAssetStoreRequest $request): StoreAssetResource
    {
        $this->authorize('create', StoreAsset::class);

        $validated = $request->validated();

        $storeAsset = StoreAsset::create($validated);

        return new StoreAssetResource($storeAsset);
    }

    public function show(
        Request $request,
        StoreAsset $storeAsset
    ): StoreAssetResource {
        $this->authorize('view', $storeAsset);

        return new StoreAssetResource($storeAsset);
    }

    public function update(
        StoreAssetUpdateRequest $request,
        StoreAsset $storeAsset
    ): StoreAssetResource {
        $this->authorize('update', $storeAsset);

        $validated = $request->validated();

        $storeAsset->update($validated);

        return new StoreAssetResource($storeAsset);
    }

    public function destroy(Request $request, StoreAsset $storeAsset): Response
    {
        $this->authorize('delete', $storeAsset);

        $storeAsset->delete();

        return response()->noContent();
    }
}
