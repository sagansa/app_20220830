<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\ClosingStore;
use Illuminate\Http\Response;
use App\Models\PurchaseOrder;
use App\Http\Controllers\Controller;
use App\Http\Resources\PurchaseOrderCollection;

class ClosingStorePurchaseOrdersController extends Controller
{
    public function index(
        Request $request,
        ClosingStore $closingStore
    ): PurchaseOrderCollection {
        $this->authorize('view', $closingStore);

        $search = $request->get('search', '');

        $purchaseOrders = $closingStore
            ->purchaseOrders()
            ->search($search)
            ->latest()
            ->paginate();

        return new PurchaseOrderCollection($purchaseOrders);
    }

    public function store(
        Request $request,
        ClosingStore $closingStore,
        PurchaseOrder $purchaseOrder
    ): Response {
        $this->authorize('update', $closingStore);

        $closingStore
            ->purchaseOrders()
            ->syncWithoutDetaching([$purchaseOrder->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        ClosingStore $closingStore,
        PurchaseOrder $purchaseOrder
    ): Response {
        $this->authorize('update', $closingStore);

        $closingStore->purchaseOrders()->detach($purchaseOrder);

        return response()->noContent();
    }
}
