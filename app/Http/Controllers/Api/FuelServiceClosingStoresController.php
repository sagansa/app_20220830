<?php
namespace App\Http\Controllers\Api;

use App\Models\FuelService;
use Illuminate\Http\Request;
use App\Models\ClosingStore;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClosingStoreCollection;

class FuelServiceClosingStoresController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FuelService $fuelService
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, FuelService $fuelService)
    {
        $this->authorize('view', $fuelService);

        $search = $request->get('search', '');

        $closingStores = $fuelService
            ->closingStores()
            ->search($search)
            ->latest()
            ->paginate();

        return new ClosingStoreCollection($closingStores);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FuelService $fuelService
     * @param \App\Models\ClosingStore $closingStore
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        FuelService $fuelService,
        ClosingStore $closingStore
    ) {
        $this->authorize('update', $fuelService);

        $fuelService
            ->closingStores()
            ->syncWithoutDetaching([$closingStore->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FuelService $fuelService
     * @param \App\Models\ClosingStore $closingStore
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        FuelService $fuelService,
        ClosingStore $closingStore
    ) {
        $this->authorize('update', $fuelService);

        $fuelService->closingStores()->detach($closingStore);

        return response()->noContent();
    }
}
