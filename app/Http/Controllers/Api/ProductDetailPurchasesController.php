<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DetailPurchaseResource;
use App\Http\Resources\DetailPurchaseCollection;

class ProductDetailPurchasesController extends Controller
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

        $detailPurchases = $product
            ->detailPurchases()
            ->search($search)
            ->latest()
            ->paginate();

        return new DetailPurchaseCollection($detailPurchases);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product)
    {
        $this->authorize('create', DetailPurchase::class);

        $validated = $request->validate([
            'quantity_plan' => ['required', 'numeric'],
            'status' => ['required', 'max:255'],
            'notes' => ['nullable', 'max:255', 'string'],
            'purchase_submission_id' => [
                'required',
                'exists:purchase_submissions,id',
            ],
        ]);

        $detailPurchase = $product->detailPurchases()->create($validated);

        return new DetailPurchaseResource($detailPurchase);
    }
}
