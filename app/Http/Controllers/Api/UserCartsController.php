<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\CartResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartCollection;

class UserCartsController extends Controller
{
    public function index(Request $request, User $user): CartCollection
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $carts = $user
            ->carts()
            ->search($search)
            ->latest()
            ->paginate();

        return new CartCollection($carts);
    }

    public function store(Request $request, User $user): CartResource
    {
        $this->authorize('create', Cart::class);

        $validated = $request->validate([
            'e_product_id' => ['required', 'exists:e_products,id'],
            'quantity' => ['required', 'numeric'],
        ]);

        $cart = $user->carts()->create($validated);

        return new CartResource($cart);
    }
}
