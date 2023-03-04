<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\OnlineShopProvider;
use App\Http\Controllers\Controller;
use App\Http\Resources\OnlineShopProviderResource;
use App\Http\Resources\OnlineShopProviderCollection;
use App\Http\Requests\OnlineShopProviderStoreRequest;
use App\Http\Requests\OnlineShopProviderUpdateRequest;

class OnlineShopProviderController extends Controller
{
    public function index(Request $request): OnlineShopProviderCollection
    {
        $this->authorize('view-any', OnlineShopProvider::class);

        $search = $request->get('search', '');

        $onlineShopProviders = OnlineShopProvider::search($search)
            ->latest()
            ->paginate();

        return new OnlineShopProviderCollection($onlineShopProviders);
    }

    public function store(
        OnlineShopProviderStoreRequest $request
    ): OnlineShopProviderResource {
        $this->authorize('create', OnlineShopProvider::class);

        $validated = $request->validated();

        $onlineShopProvider = OnlineShopProvider::create($validated);

        return new OnlineShopProviderResource($onlineShopProvider);
    }

    public function show(
        Request $request,
        OnlineShopProvider $onlineShopProvider
    ): OnlineShopProviderResource {
        $this->authorize('view', $onlineShopProvider);

        return new OnlineShopProviderResource($onlineShopProvider);
    }

    public function update(
        OnlineShopProviderUpdateRequest $request,
        OnlineShopProvider $onlineShopProvider
    ): OnlineShopProviderResource {
        $this->authorize('update', $onlineShopProvider);

        $validated = $request->validated();

        $onlineShopProvider->update($validated);

        return new OnlineShopProviderResource($onlineShopProvider);
    }

    public function destroy(
        Request $request,
        OnlineShopProvider $onlineShopProvider
    ): Response {
        $this->authorize('delete', $onlineShopProvider);

        $onlineShopProvider->delete();

        return response()->noContent();
    }
}
