<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SelfConsumptionResource;
use App\Http\Resources\SelfConsumptionCollection;

class UserSelfConsumptionsController extends Controller
{
    public function index(
        Request $request,
        User $user
    ): SelfConsumptionCollection {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $selfConsumptions = $user
            ->selfConsumptionsApproved()
            ->search($search)
            ->latest()
            ->paginate();

        return new SelfConsumptionCollection($selfConsumptions);
    }

    public function store(Request $request, User $user): SelfConsumptionResource
    {
        $this->authorize('create', SelfConsumption::class);

        $validated = $request->validate([
            'store_id' => ['required', 'exists:stores,id'],
            'date' => ['required', 'date'],
            'status' => ['required', 'max:255'],
            'notes' => ['nullable', 'max:255', 'string'],
        ]);

        $selfConsumption = $user
            ->selfConsumptionsApproved()
            ->create($validated);

        return new SelfConsumptionResource($selfConsumption);
    }
}
