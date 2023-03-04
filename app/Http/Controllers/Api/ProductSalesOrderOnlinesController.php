<?php
namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\SalesOrderOnline;
use App\Http\Controllers\Controller;
use App\Http\Resources\SalesOrderOnlineCollection;

class ProductSalesOrderOnlinesController extends Controller
{
    public function index(
        Request $request,
        Product $product
    ): SalesOrderOnlineCollection {
        $this->authorize('view', $product);

        $search = $request->get('search', '');

        $salesOrderOnlines = $product
            ->salesOrderOnlines()
            ->search($search)
            ->latest()
            ->paginate();

        return new SalesOrderOnlineCollection($salesOrderOnlines);
    }

    public function store(
        Request $request,
        Product $product,
        SalesOrderOnline $salesOrderOnline
    ): Response {
        $this->authorize('update', $product);

        $product
            ->salesOrderOnlines()
            ->syncWithoutDetaching([$salesOrderOnline->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        Product $product,
        SalesOrderOnline $salesOrderOnline
    ): Response {
        $this->authorize('update', $product);

        $product->salesOrderOnlines()->detach($salesOrderOnline);

        return response()->noContent();
    }
}
