<?php

namespace App\Http\Controllers\Api;

use App\Models\EProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SalesOrderDirectProductResource;
use App\Http\Resources\SalesOrderDirectProductCollection;

class EProductSalesOrderDirectProductsController extends Controller
{
    public function index(
        Request $request,
        EProduct $eProduct
    ): SalesOrderDirectProductCollection {
        $this->authorize('view', $eProduct);

        $search = $request->get('search', '');

        $salesOrderDirectProducts = $eProduct
            ->salesOrderDirectProducts()
            ->search($search)
            ->latest()
            ->paginate();

        return new SalesOrderDirectProductCollection($salesOrderDirectProducts);
    }

    public function store(
        Request $request,
        EProduct $eProduct
    ): SalesOrderDirectProductResource {
        $this->authorize('create', SalesOrderDirectProduct::class);

        $validated = $request->validate([
            'quantity' => ['required', 'numeric'],
            'price' => ['required', 'numeric'],
            'amount' => ['required', 'numeric'],
        ]);

        $salesOrderDirectProduct = $eProduct
            ->salesOrderDirectProducts()
            ->create($validated);

        return new SalesOrderDirectProductResource($salesOrderDirectProduct);
    }
}
