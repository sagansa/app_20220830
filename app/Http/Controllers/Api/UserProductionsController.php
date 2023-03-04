<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductionResource;
use App\Http\Resources\ProductionCollection;

class UserProductionsController extends Controller
{
    public function index(Request $request, User $user): ProductionCollection
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $productions = $user
            ->productionsApproved()
            ->search($search)
            ->latest()
            ->paginate();

        return new ProductionCollection($productions);
    }

    public function store(Request $request, User $user): ProductionResource
    {
        $this->authorize('create', Production::class);

        $validated = $request->validate([
            'store_id' => ['required', 'exists:stores,id'],
            'date' => ['required', 'date'],
            'notes' => ['nullable', 'max:255', 'string'],
            'status' => ['required', 'max:255'],
        ]);

        $production = $user->productionsApproved()->create($validated);

        return new ProductionResource($production);
    }
}
