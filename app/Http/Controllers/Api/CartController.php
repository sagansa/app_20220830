<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\CartResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartCollection;
use App\Http\Requests\CartStoreRequest;
use App\Http\Requests\CartUpdateRequest;

class CartController extends Controller
{
    public function index(Request $request): CartCollection
    {
        $this->authorize('view-any', Cart::class);

        $search = $request->get('search', '');

        $carts = Cart::search($search)
            ->latest()
            ->paginate();

        return new CartCollection($carts);
    }

    public function store(CartStoreRequest $request): CartResource
    {
        $this->authorize('create', Cart::class);

        $validated = $request->validated();

        $cart = Cart::create($validated);

        return new CartResource($cart);
    }

    public function show(Request $request, Cart $cart): CartResource
    {
        $this->authorize('view', $cart);

        return new CartResource($cart);
    }

    public function update(CartUpdateRequest $request, Cart $cart): CartResource
    {
        $this->authorize('update', $cart);

        $validated = $request->validated();

        $cart->update($validated);

        return new CartResource($cart);
    }

    public function destroy(Request $request, Cart $cart): Response
    {
        $this->authorize('delete', $cart);

        $cart->delete();

        return response()->noContent();
    }
}
