<?php

namespace App\Http\Controllers\Api;

use App\Models\EProduct;
use Illuminate\Http\Request;
use App\Http\Resources\CartResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartCollection;

class EProductCartsController extends Controller
{
    public function index(Request $request, EProduct $eProduct): CartCollection
    {
        $this->authorize('view', $eProduct);

        $search = $request->get('search', '');

        $carts = $eProduct
            ->carts()
            ->search($search)
            ->latest()
            ->paginate();

        return new CartCollection($carts);
    }

    public function store(Request $request, EProduct $eProduct): CartResource
    {
        $this->authorize('create', Cart::class);

        $validated = $request->validate([
            'quantity' => ['required', 'numeric'],
            'user_id' => ['required', 'exists:users,id'],
        ]);

        $cart = $eProduct->carts()->create($validated);

        return new CartResource($cart);
    }
}
