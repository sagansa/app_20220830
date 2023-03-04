<?php
namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\SelfConsumption;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;

class SelfConsumptionProductsController extends Controller
{
    public function index(
        Request $request,
        SelfConsumption $selfConsumption
    ): ProductCollection {
        $this->authorize('view', $selfConsumption);

        $search = $request->get('search', '');

        $products = $selfConsumption
            ->products()
            ->search($search)
            ->latest()
            ->paginate();

        return new ProductCollection($products);
    }

    public function store(
        Request $request,
        SelfConsumption $selfConsumption,
        Product $product
    ): Response {
        $this->authorize('update', $selfConsumption);

        $selfConsumption->products()->syncWithoutDetaching([$product->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        SelfConsumption $selfConsumption,
        Product $product
    ): Response {
        $this->authorize('update', $selfConsumption);

        $selfConsumption->products()->detach($product);

        return response()->noContent();
    }
}
