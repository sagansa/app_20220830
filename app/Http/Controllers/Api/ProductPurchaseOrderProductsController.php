<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PurchaseOrderProductResource;
use App\Http\Resources\PurchaseOrderProductCollection;

class ProductPurchaseOrderProductsController extends Controller
{
    public function index(
        Request $request,
        Product $product
    ): PurchaseOrderProductCollection {
        $this->authorize('view', $product);

        $search = $request->get('search', '');

        $purchaseOrderProducts = $product
            ->purchaseOrderProducts()
            ->search($search)
            ->latest()
            ->paginate();

        return new PurchaseOrderProductCollection($purchaseOrderProducts);
    }

    public function store(
        Request $request,
        Product $product
    ): PurchaseOrderProductResource {
        $this->authorize('create', PurchaseOrderProduct::class);

        $validated = $request->validate([
            'quantity_product' => ['required', 'numeric'],
            'unit_id' => ['required', 'exists:units,id'],
            'quantity_invoice' => ['required', 'numeric'],
            'subtotal_invoice' => ['required', 'max:255'],
            'status' => ['required', 'max:255'],
        ]);

        $purchaseOrderProduct = $product
            ->purchaseOrderProducts()
            ->create($validated);

        return new PurchaseOrderProductResource($purchaseOrderProduct);
    }
}
