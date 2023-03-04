<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\ClosingStore;
use Illuminate\Http\Response;
use App\Models\ClosingCourier;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClosingStoreCollection;

class ClosingCourierClosingStoresController extends Controller
{
    public function index(
        Request $request,
        ClosingCourier $closingCourier
    ): ClosingStoreCollection {
        $this->authorize('view', $closingCourier);

        $search = $request->get('search', '');

        $closingStores = $closingCourier
            ->closingStores()
            ->search($search)
            ->latest()
            ->paginate();

        return new ClosingStoreCollection($closingStores);
    }

    public function store(
        Request $request,
        ClosingCourier $closingCourier,
        ClosingStore $closingStore
    ): Response {
        $this->authorize('update', $closingCourier);

        $closingCourier
            ->closingStores()
            ->syncWithoutDetaching([$closingStore->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        ClosingCourier $closingCourier,
        ClosingStore $closingStore
    ): Response {
        $this->authorize('update', $closingCourier);

        $closingCourier->closingStores()->detach($closingStore);

        return response()->noContent();
    }
}
