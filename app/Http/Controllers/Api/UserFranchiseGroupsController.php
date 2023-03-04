<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\FranchiseGroupResource;
use App\Http\Resources\FranchiseGroupCollection;

class UserFranchiseGroupsController extends Controller
{
    public function index(
        Request $request,
        User $user
    ): FranchiseGroupCollection {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $franchiseGroups = $user
            ->franchiseGroups()
            ->search($search)
            ->latest()
            ->paginate();

        return new FranchiseGroupCollection($franchiseGroups);
    }

    public function store(Request $request, User $user): FranchiseGroupResource
    {
        $this->authorize('create', FranchiseGroup::class);

        $validated = $request->validate([
            'name' => ['required', 'max:50', 'string'],
            'status' => ['required', 'max:255'],
        ]);

        $franchiseGroup = $user->franchiseGroups()->create($validated);

        return new FranchiseGroupResource($franchiseGroup);
    }
}
