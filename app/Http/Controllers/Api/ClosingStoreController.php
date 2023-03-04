<?php

namespace App\Http\Controllers\Api;

use App\Models\ClosingStore;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClosingStoreResource;
use App\Http\Resources\ClosingStoreCollection;
use App\Http\Requests\ClosingStoreStoreRequest;
use App\Http\Requests\ClosingStoreUpdateRequest;

class ClosingStoreController extends Controller
{
    public function index(Request $request): ClosingStoreCollection
    {
        $this->authorize('view-any', ClosingStore::class);

        $search = $request->get('search', '');

        $closingStores = ClosingStore::search($search)
            ->latest()
            ->paginate();

        return new ClosingStoreCollection($closingStores);
    }

    public function store(
        ClosingStoreStoreRequest $request
    ): ClosingStoreResource {
        $this->authorize('create', ClosingStore::class);

        $validated = $request->validated();

        $closingStore = ClosingStore::create($validated);

        return new ClosingStoreResource($closingStore);
    }

    public function show(
        Request $request,
        ClosingStore $closingStore
    ): ClosingStoreResource {
        $this->authorize('view', $closingStore);

        return new ClosingStoreResource($closingStore);
    }

    public function update(
        ClosingStoreUpdateRequest $request,
        ClosingStore $closingStore
    ): ClosingStoreResource {
        $this->authorize('update', $closingStore);

        $validated = $request->validated();

        $closingStore->update($validated);

        return new ClosingStoreResource($closingStore);
    }

    public function destroy(
        Request $request,
        ClosingStore $closingStore
    ): Response {
        $this->authorize('delete', $closingStore);

        $closingStore->delete();

        return response()->noContent();
    }
}
