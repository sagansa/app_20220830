<?php
namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\SalesOrderEmployee;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;

class SalesOrderEmployeeProductsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SalesOrderEmployee $salesOrderEmployee
     * @return \Illuminate\Http\Response
     */
    public function index(
        Request $request,
        SalesOrderEmployee $salesOrderEmployee
    ) {
        $this->authorize('view', $salesOrderEmployee);

        $search = $request->get('search', '');

        $products = $salesOrderEmployee
            ->products()
            ->search($search)
            ->latest()
            ->paginate();

        return new ProductCollection($products);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SalesOrderEmployee $salesOrderEmployee
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        SalesOrderEmployee $salesOrderEmployee,
        Product $product
    ) {
        $this->authorize('update', $salesOrderEmployee);

        $salesOrderEmployee->products()->syncWithoutDetaching([$product->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SalesOrderEmployee $salesOrderEmployee
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        SalesOrderEmployee $salesOrderEmployee,
        Product $product
    ) {
        $this->authorize('update', $salesOrderEmployee);

        $salesOrderEmployee->products()->detach($product);

        return response()->noContent();
    }
}
