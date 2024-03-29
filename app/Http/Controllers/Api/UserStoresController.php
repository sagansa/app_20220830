<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\StoreResource;
use App\Http\Resources\StoreCollection;

class UserStoresController extends Controller
{
    public function index(Request $request, User $user): StoreCollection
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $stores = $user
            ->stores()
            ->search($search)
            ->latest()
            ->paginate();

        return new StoreCollection($stores);
    }

    public function store(Request $request, User $user): StoreResource
    {
        $this->authorize('create', Store::class);

        $validated = $request->validate([
            'nickname' => ['required', 'max:255', 'string'],
            'name' => ['required', 'max:255', 'string'],
            'no_telp' => ['nullable', 'max:255', 'string'],
            'email' => ['required', 'unique:stores,email', 'email'],
            'status' => ['required', 'max:255'],
        ]);

        $store = $user->stores()->create($validated);

        return new StoreResource($store);
    }
}
