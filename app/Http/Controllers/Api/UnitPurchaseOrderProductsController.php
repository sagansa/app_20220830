<?php

namespace App\Http\Controllers\Api;

use App\Models\Unit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PurchaseOrderProductResource;
use App\Http\Resources\PurchaseOrderProductCollection;

class UnitPurchaseOrderProductsController extends Controller
{
    public function index(
        Request $request,
        Unit $unit
    ): PurchaseOrderProductCollection {
        $this->authorize('view', $unit);

        $search = $request->get('search', '');

        $purchaseOrderProducts = $unit
            ->purchaseOrderProducts()
            ->search($search)
            ->latest()
            ->paginate();

        return new PurchaseOrderProductCollection($purchaseOrderProducts);
    }

    public function store(
        Request $request,
        Unit $unit
    ): PurchaseOrderProductResource {
        $this->authorize('create', PurchaseOrderProduct::class);

        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity_product' => ['required', 'numeric'],
            'quantity_invoice' => ['required', 'numeric'],
            'subtotal_invoice' => ['required', 'max:255'],
            'status' => ['required', 'max:255'],
        ]);

        $purchaseOrderProduct = $unit
            ->purchaseOrderProducts()
            ->create($validated);

        return new PurchaseOrderProductResource($purchaseOrderProduct);
    }
}
