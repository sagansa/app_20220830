<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\ClosingStore;
use Illuminate\Http\Response;
use App\Models\ClosingCourier;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClosingCourierCollection;

class ClosingStoreClosingCouriersController extends Controller
{
    public function index(
        Request $request,
        ClosingStore $closingStore
    ): ClosingCourierCollection {
        $this->authorize('view', $closingStore);

        $search = $request->get('search', '');

        $closingCouriers = $closingStore
            ->closingCouriers()
            ->search($search)
            ->latest()
            ->paginate();

        return new ClosingCourierCollection($closingCouriers);
    }

    public function store(
        Request $request,
        ClosingStore $closingStore,
        ClosingCourier $closingCourier
    ): Response {
        $this->authorize('update', $closingStore);

        $closingStore
            ->closingCouriers()
            ->syncWithoutDetaching([$closingCourier->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        ClosingStore $closingStore,
        ClosingCourier $closingCourier
    ): Response {
        $this->authorize('update', $closingStore);

        $closingStore->closingCouriers()->detach($closingCourier);

        return response()->noContent();
    }
}
