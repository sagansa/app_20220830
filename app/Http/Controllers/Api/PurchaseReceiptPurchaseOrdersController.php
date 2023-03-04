<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\PurchaseOrder;
use App\Models\PurchaseReceipt;
use App\Http\Controllers\Controller;
use App\Http\Resources\PurchaseOrderCollection;

class PurchaseReceiptPurchaseOrdersController extends Controller
{
    public function index(
        Request $request,
        PurchaseReceipt $purchaseReceipt
    ): PurchaseOrderCollection {
        $this->authorize('view', $purchaseReceipt);

        $search = $request->get('search', '');

        $purchaseOrders = $purchaseReceipt
            ->purchaseOrders()
            ->search($search)
            ->latest()
            ->paginate();

        return new PurchaseOrderCollection($purchaseOrders);
    }

    public function store(
        Request $request,
        PurchaseReceipt $purchaseReceipt,
        PurchaseOrder $purchaseOrder
    ): Response {
        $this->authorize('update', $purchaseReceipt);

        $purchaseReceipt
            ->purchaseOrders()
            ->syncWithoutDetaching([$purchaseOrder->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        PurchaseReceipt $purchaseReceipt,
        PurchaseOrder $purchaseOrder
    ): Response {
        $this->authorize('update', $purchaseReceipt);

        $purchaseReceipt->purchaseOrders()->detach($purchaseOrder);

        return response()->noContent();
    }
}
