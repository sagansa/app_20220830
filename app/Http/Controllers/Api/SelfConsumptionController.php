<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\SelfConsumption;
use App\Http\Controllers\Controller;
use App\Http\Resources\SelfConsumptionResource;
use App\Http\Resources\SelfConsumptionCollection;
use App\Http\Requests\SelfConsumptionStoreRequest;
use App\Http\Requests\SelfConsumptionUpdateRequest;

class SelfConsumptionController extends Controller
{
    public function index(Request $request): SelfConsumptionCollection
    {
        $this->authorize('view-any', SelfConsumption::class);

        $search = $request->get('search', '');

        $selfConsumptions = SelfConsumption::search($search)
            ->latest()
            ->paginate();

        return new SelfConsumptionCollection($selfConsumptions);
    }

    public function store(
        SelfConsumptionStoreRequest $request
    ): SelfConsumptionResource {
        $this->authorize('create', SelfConsumption::class);

        $validated = $request->validated();

        $selfConsumption = SelfConsumption::create($validated);

        return new SelfConsumptionResource($selfConsumption);
    }

    public function show(
        Request $request,
        SelfConsumption $selfConsumption
    ): SelfConsumptionResource {
        $this->authorize('view', $selfConsumption);

        return new SelfConsumptionResource($selfConsumption);
    }

    public function update(
        SelfConsumptionUpdateRequest $request,
        SelfConsumption $selfConsumption
    ): SelfConsumptionResource {
        $this->authorize('update', $selfConsumption);

        $validated = $request->validated();

        $selfConsumption->update($validated);

        return new SelfConsumptionResource($selfConsumption);
    }

    public function destroy(
        Request $request,
        SelfConsumption $selfConsumption
    ): Response {
        $this->authorize('delete', $selfConsumption);

        $selfConsumption->delete();

        return response()->noContent();
    }
}
