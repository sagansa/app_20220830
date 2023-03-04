<?php
namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\RemainingStock;
use App\Http\Controllers\Controller;
use App\Http\Resources\RemainingStockCollection;

class ProductRemainingStocksController extends Controller
{
    public function index(
        Request $request,
        Product $product
    ): RemainingStockCollection {
        $this->authorize('view', $product);

        $search = $request->get('search', '');

        $remainingStocks = $product
            ->remainingStocks()
            ->search($search)
            ->latest()
            ->paginate();

        return new RemainingStockCollection($remainingStocks);
    }

    public function store(
        Request $request,
        Product $product,
        RemainingStock $remainingStock
    ): Response {
        $this->authorize('update', $product);

        $product
            ->remainingStocks()
            ->syncWithoutDetaching([$remainingStock->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        Product $product,
        RemainingStock $remainingStock
    ): Response {
        $this->authorize('update', $product);

        $product->remainingStocks()->detach($remainingStock);

        return response()->noContent();
    }
}
