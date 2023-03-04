<?php

namespace App\Http\Controllers\Api;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\EProductResource;
use App\Http\Resources\EProductCollection;

class StoreEProductsController extends Controller
{
    public function index(Request $request, Store $store): EProductCollection
    {
        $this->authorize('view', $store);

        $search = $request->get('search', '');

        $eProducts = $store
            ->eProducts()
            ->search($search)
            ->latest()
            ->paginate();

        return new EProductCollection($eProducts);
    }

    public function store(Request $request, Store $store): EProductResource
    {
        $this->authorize('create', EProduct::class);

        $validated = $request->validate([
            'image' => ['nullable', 'image'],
            'product_id' => ['required', 'exists:products,id'],
            'online_category_id' => ['required', 'exists:online_categories,id'],
            'quantity_stock' => ['required', 'numeric', 'min:0'],
            'price' => ['required', 'numeric', 'gt:0'],
            'status' => ['required', 'in:1,2'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $eProduct = $store->eProducts()->create($validated);

        return new EProductResource($eProduct);
    }
}
