<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DetailRequestResource;
use App\Http\Resources\DetailRequestCollection;

class ProductDetailRequestsController extends Controller
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

        $detailRequests = $product
            ->detailRequests()
            ->search($search)
            ->latest()
            ->paginate();

        return new DetailRequestCollection($detailRequests);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product)
    {
        $this->authorize('create', DetailRequest::class);

        $validated = $request->validate([
            'quantity_plan' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:1,2,3,4,5'],
            'notes' => ['nullable', 'max:255', 'string'],
        ]);

        $detailRequest = $product->detailRequests()->create($validated);

        return new DetailRequestResource($detailRequest);
    }
}
