<?php
namespace App\Http\Controllers\Api;

use App\Models\FuelService;
use Illuminate\Http\Request;
use App\Models\ClosingStore;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\FuelServiceCollection;

class ClosingStoreFuelServicesController extends Controller
{
    public function index(
        Request $request,
        ClosingStore $closingStore
    ): FuelServiceCollection {
        $this->authorize('view', $closingStore);

        $search = $request->get('search', '');

        $fuelServices = $closingStore
            ->fuelServices()
            ->search($search)
            ->latest()
            ->paginate();

        return new FuelServiceCollection($fuelServices);
    }

    public function store(
        Request $request,
        ClosingStore $closingStore,
        FuelService $fuelService
    ): Response {
        $this->authorize('update', $closingStore);

        $closingStore->fuelServices()->syncWithoutDetaching([$fuelService->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        ClosingStore $closingStore,
        FuelService $fuelService
    ): Response {
        $this->authorize('update', $closingStore);

        $closingStore->fuelServices()->detach($fuelService);

        return response()->noContent();
    }
}
