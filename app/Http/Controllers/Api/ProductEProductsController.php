<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\EProductResource;
use App\Http\Resources\EProductCollection;

class ProductEProductsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Product $product)
    {
        $this->authorize('view', $product);

        $search = $request->get('search', '');

        $eProducts = $product
            ->eProducts()
            ->search($search)
            ->latest()
            ->paginate();

        return new EProductCollection($eProducts);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product)
    {
        $this->authorize('create', EProduct::class);

        $validated = $request->validate([
            'image' => ['nullable', 'image', 'max:1024'],
            'online_category_id' => ['required', 'exists:online_categories,id'],
            'store_id' => ['required', 'exists:stores,id'],
            'quantity_stock' => ['required', 'max:255'],
            'price' => ['required', 'numeric'],
            'status' => ['required', 'max:255'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $eProduct = $product->eProducts()->create($validated);

        return new EProductResource($eProduct);
    }
}
