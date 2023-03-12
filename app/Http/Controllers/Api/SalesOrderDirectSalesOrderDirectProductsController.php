<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\SalesOrderDirect;
use App\Http\Controllers\Controller;
use App\Http\Resources\SalesOrderDirectProductResource;
use App\Http\Resources\SalesOrderDirectProductCollection;

class SalesOrderDirectSalesOrderDirectProductsController extends Controller
{
    public function index(
        Request $request,
        SalesOrderDirect $salesOrderDirect
    ): SalesOrderDirectProductCollection {
        $this->authorize('view', $salesOrderDirect);

        $search = $request->get('search', '');

        $salesOrderDirectProducts = $salesOrderDirect
            ->salesOrderDirectProducts()
            ->search($search)
            ->latest()
            ->paginate();

        return new SalesOrderDirectProductCollection($salesOrderDirectProducts);
    }

    public function store(
        Request $request,
        SalesOrderDirect $salesOrderDirect
    ): SalesOrderDirectProductResource {
        $this->authorize('create', SalesOrderDirectProduct::class);

        $validated = $request->validate([
            'e_product_id' => ['required', 'exists:e_products,id'],
            'quantity' => ['required', 'numeric'],
            'price' => ['required', 'numeric'],
            'amount' => ['required', 'numeric'],
        ]);

        $salesOrderDirectProduct = $salesOrderDirect
            ->salesOrderDirectProducts()
            ->create($validated);

        return new SalesOrderDirectProductResource($salesOrderDirectProduct);
    }
}
