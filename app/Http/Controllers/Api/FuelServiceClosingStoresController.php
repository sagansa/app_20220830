<?php
namespace App\Http\Controllers\Api;

use App\Models\FuelService;
use Illuminate\Http\Request;
use App\Models\ClosingStore;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClosingStoreCollection;

class FuelServiceClosingStoresController extends Controller
{
    public function index(
        Request $request,
        FuelService $fuelService
    ): ClosingStoreCollection {
        $this->authorize('view', $fuelService);

        $search = $request->get('search', '');

        $closingStores = $fuelService
            ->closingStores()
            ->search($search)
            ->latest()
            ->paginate();

        return new ClosingStoreCollection($closingStores);
    }

    public function store(
        Request $request,
        FuelService $fuelService,
        ClosingStore $closingStore
    ): Response {
        $this->authorize('update', $fuelService);

        $fuelService
            ->closingStores()
            ->syncWithoutDetaching([$closingStore->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        FuelService $fuelService,
        ClosingStore $closingStore
    ): Response {
        $this->authorize('update', $fuelService);

        $fuelService->closingStores()->detach($closingStore);

        return response()->noContent();
    }
}
