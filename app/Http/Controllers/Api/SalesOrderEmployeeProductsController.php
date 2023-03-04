<?php
namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\SalesOrderEmployee;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;

class SalesOrderEmployeeProductsController extends Controller
{
    public function index(
        Request $request,
        SalesOrderEmployee $salesOrderEmployee
    ): ProductCollection {
        $this->authorize('view', $salesOrderEmployee);

        $search = $request->get('search', '');

        $products = $salesOrderEmployee
            ->products()
            ->search($search)
            ->latest()
            ->paginate();

        return new ProductCollection($products);
    }

    public function store(
        Request $request,
        SalesOrderEmployee $salesOrderEmployee,
        Product $product
    ): Response {
        $this->authorize('update', $salesOrderEmployee);

        $salesOrderEmployee->products()->syncWithoutDetaching([$product->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        SalesOrderEmployee $salesOrderEmployee,
        Product $product
    ): Response {
        $this->authorize('update', $salesOrderEmployee);

        $salesOrderEmployee->products()->detach($product);

        return response()->noContent();
    }
}
