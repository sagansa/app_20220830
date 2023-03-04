<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\UtilityProvider;
use App\Http\Controllers\Controller;
use App\Http\Resources\UtilityProviderResource;
use App\Http\Resources\UtilityProviderCollection;
use App\Http\Requests\UtilityProviderStoreRequest;
use App\Http\Requests\UtilityProviderUpdateRequest;

class UtilityProviderController extends Controller
{
    public function index(Request $request): UtilityProviderCollection
    {
        $this->authorize('view-any', UtilityProvider::class);

        $search = $request->get('search', '');

        $utilityProviders = UtilityProvider::search($search)
            ->latest()
            ->paginate();

        return new UtilityProviderCollection($utilityProviders);
    }

    public function store(
        UtilityProviderStoreRequest $request
    ): UtilityProviderResource {
        $this->authorize('create', UtilityProvider::class);

        $validated = $request->validated();

        $utilityProvider = UtilityProvider::create($validated);

        return new UtilityProviderResource($utilityProvider);
    }

    public function show(
        Request $request,
        UtilityProvider $utilityProvider
    ): UtilityProviderResource {
        $this->authorize('view', $utilityProvider);

        return new UtilityProviderResource($utilityProvider);
    }

    public function update(
        UtilityProviderUpdateRequest $request,
        UtilityProvider $utilityProvider
    ): UtilityProviderResource {
        $this->authorize('update', $utilityProvider);

        $validated = $request->validated();

        $utilityProvider->update($validated);

        return new UtilityProviderResource($utilityProvider);
    }

    public function destroy(
        Request $request,
        UtilityProvider $utilityProvider
    ): Response {
        $this->authorize('delete', $utilityProvider);

        $utilityProvider->delete();

        return response()->noContent();
    }
}
