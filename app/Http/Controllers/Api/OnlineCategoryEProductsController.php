<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\OnlineCategory;
use App\Http\Controllers\Controller;
use App\Http\Resources\EProductResource;
use App\Http\Resources\EProductCollection;

class OnlineCategoryEProductsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\OnlineCategory $onlineCategory
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, OnlineCategory $onlineCategory)
    {
        $this->authorize('view', $onlineCategory);

        $search = $request->get('search', '');

        $eProducts = $onlineCategory
            ->eProducts()
            ->search($search)
            ->latest()
            ->paginate();

        return new EProductCollection($eProducts);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\OnlineCategory $onlineCategory
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, OnlineCategory $onlineCategory)
    {
        $this->authorize('create', EProduct::class);

        $validated = $request->validate([
            'image' => ['nullable', 'image', 'max:1024'],
            'product_id' => ['required', 'exists:products,id'],
            'store_id' => ['required', 'exists:stores,id'],
            'quantity_stock' => ['required', 'max:255'],
            'price' => ['required', 'numeric'],
            'status' => ['required', 'max:255'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $eProduct = $onlineCategory->eProducts()->create($validated);

        return new EProductResource($eProduct);
    }
}
