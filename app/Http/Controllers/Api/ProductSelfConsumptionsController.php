<?php
namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\SelfConsumption;
use App\Http\Controllers\Controller;
use App\Http\Resources\SelfConsumptionCollection;

class ProductSelfConsumptionsController extends Controller
{
    public function index(
        Request $request,
        Product $product
    ): SelfConsumptionCollection {
        $this->authorize('view', $product);

        $search = $request->get('search', '');

        $selfConsumptions = $product
            ->selfConsumptions()
            ->search($search)
            ->latest()
            ->paginate();

        return new SelfConsumptionCollection($selfConsumptions);
    }

    public function store(
        Request $request,
        Product $product,
        SelfConsumption $selfConsumption
    ): Response {
        $this->authorize('update', $product);

        $product
            ->selfConsumptions()
            ->syncWithoutDetaching([$selfConsumption->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        Product $product,
        SelfConsumption $selfConsumption
    ): Response {
        $this->authorize('update', $product);

        $product->selfConsumptions()->detach($selfConsumption);

        return response()->noContent();
    }
}
