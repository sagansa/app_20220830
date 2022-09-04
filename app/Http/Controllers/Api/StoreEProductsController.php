<?php

namespace App\Http\Controllers\Api;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\EProductResource;
use App\Http\Resources\EProductCollection;

class StoreEProductsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Store $store
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Store $store)
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

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Store $store
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Store $store)
    {
        $this->authorize('create', EProduct::class);

        $validated = $request->validate([
            'image' => ['nullable', 'image', 'max:1024'],
            'product_id' => ['required', 'exists:products,id'],
            'online_category_id' => ['required', 'exists:online_categories,id'],
            'quantity_stock' => ['required', 'max:255'],
            'price' => ['required', 'numeric'],
            'status' => ['required', 'max:255'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $eProduct = $store->eProducts()->create($validated);

        return new EProductResource($eProduct);
    }
}
