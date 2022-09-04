<?php

namespace App\Http\Controllers\Api;

use App\Models\EProduct;
use Illuminate\Http\Request;
use App\Http\Resources\CartResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartCollection;

class EProductCartsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\EProduct $eProduct
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, EProduct $eProduct)
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

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\EProduct $eProduct
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, EProduct $eProduct)
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
