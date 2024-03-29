<?php

namespace App\Http\Controllers\Api;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SelfConsumptionResource;
use App\Http\Resources\SelfConsumptionCollection;

class StoreSelfConsumptionsController extends Controller
{
    public function index(
        Request $request,
        Store $store
    ): SelfConsumptionCollection {
        $this->authorize('view', $store);

        $search = $request->get('search', '');

        $selfConsumptions = $store
            ->selfConsumptions()
            ->search($search)
            ->latest()
            ->paginate();

        return new SelfConsumptionCollection($selfConsumptions);
    }

    public function store(
        Request $request,
        Store $store
    ): SelfConsumptionResource {
        $this->authorize('create', SelfConsumption::class);

        $validated = $request->validate([
            'date' => ['required', 'date'],
            'status' => ['required', 'max:255'],
            'notes' => ['nullable', 'max:255', 'string'],
            'created_by_id' => ['nullable', 'exists:users,id'],
            'approved_by_id' => ['nullable', 'exists:users,id'],
        ]);

        $selfConsumption = $store->selfConsumptions()->create($validated);

        return new SelfConsumptionResource($selfConsumption);
    }
}
