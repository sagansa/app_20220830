<?php

namespace App\Http\Controllers\Api;

use App\Models\ShiftStore;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\ShiftStoreResource;
use App\Http\Resources\ShiftStoreCollection;
use App\Http\Requests\ShiftStoreStoreRequest;
use App\Http\Requests\ShiftStoreUpdateRequest;

class ShiftStoreController extends Controller
{
    public function index(Request $request): ShiftStoreCollection
    {
        $this->authorize('view-any', ShiftStore::class);

        $search = $request->get('search', '');

        $shiftStores = ShiftStore::search($search)
            ->latest()
            ->paginate();

        return new ShiftStoreCollection($shiftStores);
    }

    public function store(ShiftStoreStoreRequest $request): ShiftStoreResource
    {
        $this->authorize('create', ShiftStore::class);

        $validated = $request->validated();

        $shiftStore = ShiftStore::create($validated);

        return new ShiftStoreResource($shiftStore);
    }

    public function show(
        Request $request,
        ShiftStore $shiftStore
    ): ShiftStoreResource {
        $this->authorize('view', $shiftStore);

        return new ShiftStoreResource($shiftStore);
    }

    public function update(
        ShiftStoreUpdateRequest $request,
        ShiftStore $shiftStore
    ): ShiftStoreResource {
        $this->authorize('update', $shiftStore);

        $validated = $request->validated();

        $shiftStore->update($validated);

        return new ShiftStoreResource($shiftStore);
    }

    public function destroy(Request $request, ShiftStore $shiftStore): Response
    {
        $this->authorize('delete', $shiftStore);

        $shiftStore->delete();

        return response()->noContent();
    }
}
