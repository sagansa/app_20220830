<?php
namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\TransferStock;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;

class TransferStockProductsController extends Controller
{
    public function index(
        Request $request,
        TransferStock $transferStock
    ): ProductCollection {
        $this->authorize('view', $transferStock);

        $search = $request->get('search', '');

        $products = $transferStock
            ->products()
            ->search($search)
            ->latest()
            ->paginate();

        return new ProductCollection($products);
    }

    public function store(
        Request $request,
        TransferStock $transferStock,
        Product $product
    ): Response {
        $this->authorize('update', $transferStock);

        $transferStock->products()->syncWithoutDetaching([$product->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        TransferStock $transferStock,
        Product $product
    ): Response {
        $this->authorize('update', $transferStock);

        $transferStock->products()->detach($product);

        return response()->noContent();
    }
}
