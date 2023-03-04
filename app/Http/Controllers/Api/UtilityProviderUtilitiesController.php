<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\UtilityProvider;
use App\Http\Controllers\Controller;
use App\Http\Resources\UtilityResource;
use App\Http\Resources\UtilityCollection;

class UtilityProviderUtilitiesController extends Controller
{
    public function index(
        Request $request,
        UtilityProvider $utilityProvider
    ): UtilityCollection {
        $this->authorize('view', $utilityProvider);

        $search = $request->get('search', '');

        $utilities = $utilityProvider
            ->utilities()
            ->search($search)
            ->latest()
            ->paginate();

        return new UtilityCollection($utilities);
    }

    public function store(
        Request $request,
        UtilityProvider $utilityProvider
    ): UtilityResource {
        $this->authorize('create', Utility::class);

        $validated = $request->validate([
            'number' => [
                'required',
                'unique:utilities,number',
                'max:255',
                'string',
            ],
            'name' => ['required', 'max:255', 'string'],
            'store_id' => ['required', 'exists:stores,id'],
            'category' => ['required', 'max:255'],
            'unit_id' => ['required', 'exists:units,id'],
            'pre_post' => ['required', 'max:255'],
            'status' => ['required', 'max:255'],
        ]);

        $utility = $utilityProvider->utilities()->create($validated);

        return new UtilityResource($utility);
    }
}
