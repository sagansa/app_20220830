<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\RequestPurchaseResource;
use App\Http\Resources\RequestPurchaseCollection;

class UserRequestPurchasesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, User $user)
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $requestPurchases = $user
            ->requestPurchases()
            ->search($search)
            ->latest()
            ->paginate();

        return new RequestPurchaseCollection($requestPurchases);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', RequestPurchase::class);

        $validated = $request->validate([
            'store_id' => ['required', 'exists:stores,id'],
            'date' => ['required', 'date'],
            'status' => ['required', 'max:255'],
        ]);

        $requestPurchase = $user->requestPurchases()->create($validated);

        return new RequestPurchaseResource($requestPurchase);
    }
}
