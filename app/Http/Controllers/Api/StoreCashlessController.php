<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\StoreCashless;
use App\Http\Controllers\Controller;
use App\Http\Resources\StoreCashlessResource;
use App\Http\Resources\StoreCashlessCollection;
use App\Http\Requests\StoreCashlessStoreRequest;
use App\Http\Requests\StoreCashlessUpdateRequest;

class StoreCashlessController extends Controller
{
    public function index(Request $request): StoreCashlessCollection
    {
        $this->authorize('view-any', StoreCashless::class);

        $search = $request->get('search', '');

        $storeCashlesses = StoreCashless::search($search)
            ->latest()
            ->paginate();

        return new StoreCashlessCollection($storeCashlesses);
    }

    public function store(
        StoreCashlessStoreRequest $request
    ): StoreCashlessResource {
        $this->authorize('create', StoreCashless::class);

        $validated = $request->validated();

        $storeCashless = StoreCashless::create($validated);

        return new StoreCashlessResource($storeCashless);
    }

    public function show(
        Request $request,
        StoreCashless $storeCashless
    ): StoreCashlessResource {
        $this->authorize('view', $storeCashless);

        return new StoreCashlessResource($storeCashless);
    }

    public function update(
        StoreCashlessUpdateRequest $request,
        StoreCashless $storeCashless
    ): StoreCashlessResource {
        $this->authorize('update', $storeCashless);

        $validated = $request->validated();

        $storeCashless->update($validated);

        return new StoreCashlessResource($storeCashless);
    }

    public function destroy(
        Request $request,
        StoreCashless $storeCashless
    ): Response {
        $this->authorize('delete', $storeCashless);

        $storeCashless->delete();

        return response()->noContent();
    }
}
