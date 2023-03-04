<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\OnlineCategory;
use App\Http\Controllers\Controller;
use App\Http\Resources\EProductResource;
use App\Http\Resources\EProductCollection;

class OnlineCategoryEProductsController extends Controller
{
    public function index(
        Request $request,
        OnlineCategory $onlineCategory
    ): EProductCollection {
        $this->authorize('view', $onlineCategory);

        $search = $request->get('search', '');

        $eProducts = $onlineCategory
            ->eProducts()
            ->search($search)
            ->latest()
            ->paginate();

        return new EProductCollection($eProducts);
    }

    public function store(
        Request $request,
        OnlineCategory $onlineCategory
    ): EProductResource {
        $this->authorize('create', EProduct::class);

        $validated = $request->validate([
            'image' => ['nullable', 'image'],
            'product_id' => ['required', 'exists:products,id'],
            'store_id' => ['required', 'exists:stores,id'],
            'quantity_stock' => ['required', 'numeric', 'min:0'],
            'price' => ['required', 'numeric', 'gt:0'],
            'status' => ['required', 'in:1,2'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $eProduct = $onlineCategory->eProducts()->create($validated);

        return new EProductResource($eProduct);
    }
}
