<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\CashlessProvider;
use App\Http\Controllers\Controller;
use App\Http\Resources\CashlessProviderResource;
use App\Http\Resources\CashlessProviderCollection;
use App\Http\Requests\CashlessProviderStoreRequest;
use App\Http\Requests\CashlessProviderUpdateRequest;

class CashlessProviderController extends Controller
{
    public function index(Request $request): CashlessProviderCollection
    {
        $this->authorize('view-any', CashlessProvider::class);

        $search = $request->get('search', '');

        $cashlessProviders = CashlessProvider::search($search)
            ->latest()
            ->paginate();

        return new CashlessProviderCollection($cashlessProviders);
    }

    public function store(
        CashlessProviderStoreRequest $request
    ): CashlessProviderResource {
        $this->authorize('create', CashlessProvider::class);

        $validated = $request->validated();

        $cashlessProvider = CashlessProvider::create($validated);

        return new CashlessProviderResource($cashlessProvider);
    }

    public function show(
        Request $request,
        CashlessProvider $cashlessProvider
    ): CashlessProviderResource {
        $this->authorize('view', $cashlessProvider);

        return new CashlessProviderResource($cashlessProvider);
    }

    public function update(
        CashlessProviderUpdateRequest $request,
        CashlessProvider $cashlessProvider
    ): CashlessProviderResource {
        $this->authorize('update', $cashlessProvider);

        $validated = $request->validated();

        $cashlessProvider->update($validated);

        return new CashlessProviderResource($cashlessProvider);
    }

    public function destroy(
        Request $request,
        CashlessProvider $cashlessProvider
    ): Response {
        $this->authorize('delete', $cashlessProvider);

        $cashlessProvider->delete();

        return response()->noContent();
    }
}
