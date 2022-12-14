<?php
namespace App\Http\Controllers\Api;

use App\Models\FuelService;
use Illuminate\Http\Request;
use App\Models\ClosingStore;
use App\Http\Controllers\Controller;
use App\Http\Resources\FuelServiceCollection;

class ClosingStoreFuelServicesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ClosingStore $closingStore
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, ClosingStore $closingStore)
    {
        $this->authorize('view', $closingStore);

        $search = $request->get('search', '');

        $fuelServices = $closingStore
            ->fuelServices()
            ->search($search)
            ->latest()
            ->paginate();

        return new FuelServiceCollection($fuelServices);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ClosingStore $closingStore
     * @param \App\Models\FuelService $fuelService
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        ClosingStore $closingStore,
        FuelService $fuelService
    ) {
        $this->authorize('update', $closingStore);

        $closingStore->fuelServices()->syncWithoutDetaching([$fuelService->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ClosingStore $closingStore
     * @param \App\Models\FuelService $fuelService
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        ClosingStore $closingStore,
        FuelService $fuelService
    ) {
        $this->authorize('update', $closingStore);

        $closingStore->fuelServices()->detach($fuelService);

        return response()->noContent();
    }
}
