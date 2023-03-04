<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\ClosingStore;
use Illuminate\Http\Response;
use App\Models\PurchaseOrder;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClosingStoreCollection;

class PurchaseOrderClosingStoresController extends Controller
{
    public function index(
        Request $request,
        PurchaseOrder $purchaseOrder
    ): ClosingStoreCollection {
        $this->authorize('view', $purchaseOrder);

        $search = $request->get('search', '');

        $closingStores = $purchaseOrder
            ->closingStores()
            ->search($search)
            ->latest()
            ->paginate();

        return new ClosingStoreCollection($closingStores);
    }

    public function store(
        Request $request,
        PurchaseOrder $purchaseOrder,
        ClosingStore $closingStore
    ): Response {
        $this->authorize('update', $purchaseOrder);

        $purchaseOrder
            ->closingStores()
            ->syncWithoutDetaching([$closingStore->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        PurchaseOrder $purchaseOrder,
        ClosingStore $closingStore
    ): Response {
        $this->authorize('update', $purchaseOrder);

        $purchaseOrder->closingStores()->detach($closingStore);

        return response()->noContent();
    }
}
