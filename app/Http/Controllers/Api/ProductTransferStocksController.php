<?php
namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\TransferStock;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransferStockCollection;

class ProductTransferStocksController extends Controller
{
    public function index(
        Request $request,
        Product $product
    ): TransferStockCollection {
        $this->authorize('view', $product);

        $search = $request->get('search', '');

        $transferStocks = $product
            ->transferStocks()
            ->search($search)
            ->latest()
            ->paginate();

        return new TransferStockCollection($transferStocks);
    }

    public function store(
        Request $request,
        Product $product,
        TransferStock $transferStock
    ): Response {
        $this->authorize('update', $product);

        $product->transferStocks()->syncWithoutDetaching([$transferStock->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        Product $product,
        TransferStock $transferStock
    ): Response {
        $this->authorize('update', $product);

        $product->transferStocks()->detach($transferStock);

        return response()->noContent();
    }
}
