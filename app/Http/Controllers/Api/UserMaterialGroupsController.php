<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MaterialGroupResource;
use App\Http\Resources\MaterialGroupCollection;

class UserMaterialGroupsController extends Controller
{
    public function index(Request $request, User $user): MaterialGroupCollection
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $materialGroups = $user
            ->materialGroups()
            ->search($search)
            ->latest()
            ->paginate();

        return new MaterialGroupCollection($materialGroups);
    }

    public function store(Request $request, User $user): MaterialGroupResource
    {
        $this->authorize('create', MaterialGroup::class);

        $validated = $request->validate([
            'name' => ['required', 'max:50', 'string'],
            'status' => ['required', 'max:255'],
        ]);

        $materialGroup = $user->materialGroups()->create($validated);

        return new MaterialGroupResource($materialGroup);
    }
}
