<?php
namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\RemainingStock;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;

class RemainingStockProductsController extends Controller
{
    public function index(
        Request $request,
        RemainingStock $remainingStock
    ): ProductCollection {
        $this->authorize('view', $remainingStock);

        $search = $request->get('search', '');

        $products = $remainingStock
            ->products()
            ->search($search)
            ->latest()
            ->paginate();

        return new ProductCollection($products);
    }

    public function store(
        Request $request,
        RemainingStock $remainingStock,
        Product $product
    ): Response {
        $this->authorize('update', $remainingStock);

        $remainingStock->products()->syncWithoutDetaching([$product->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        RemainingStock $remainingStock,
        Product $product
    ): Response {
        $this->authorize('update', $remainingStock);

        $remainingStock->products()->detach($product);

        return response()->noContent();
    }
}
