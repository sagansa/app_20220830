<?php
namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\SalesOrderOnline;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;

class SalesOrderOnlineProductsController extends Controller
{
    public function index(
        Request $request,
        SalesOrderOnline $salesOrderOnline
    ): ProductCollection {
        $this->authorize('view', $salesOrderOnline);

        $search = $request->get('search', '');

        $products = $salesOrderOnline
            ->products()
            ->search($search)
            ->latest()
            ->paginate();

        return new ProductCollection($products);
    }

    public function store(
        Request $request,
        SalesOrderOnline $salesOrderOnline,
        Product $product
    ): Response {
        $this->authorize('update', $salesOrderOnline);

        $salesOrderOnline->products()->syncWithoutDetaching([$product->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        SalesOrderOnline $salesOrderOnline,
        Product $product
    ): Response {
        $this->authorize('update', $salesOrderOnline);

        $salesOrderOnline->products()->detach($product);

        return response()->noContent();
    }
}
