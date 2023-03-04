<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\EProductResource;
use App\Http\Resources\EProductCollection;

class ProductEProductsController extends Controller
{
    public function index(
        Request $request,
        Product $product
    ): EProductCollection {
        $this->authorize('view', $product);

        $search = $request->get('search', '');

        $eProducts = $product
            ->eProducts()
            ->search($search)
            ->latest()
            ->paginate();

        return new EProductCollection($eProducts);
    }

    public function store(Request $request, Product $product): EProductResource
    {
        $this->authorize('create', EProduct::class);

        $validated = $request->validate([
            'image' => ['nullable', 'image'],
            'online_category_id' => ['required', 'exists:online_categories,id'],
            'store_id' => ['required', 'exists:stores,id'],
            'quantity_stock' => ['required', 'numeric', 'min:0'],
            'price' => ['required', 'numeric', 'gt:0'],
            'status' => ['required', 'in:1,2'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $eProduct = $product->eProducts()->create($validated);

        return new EProductResource($eProduct);
    }
}
