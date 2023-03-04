<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\PurchaseOrder;
use App\Models\PurchaseReceipt;
use App\Http\Controllers\Controller;
use App\Http\Resources\PurchaseReceiptCollection;

class PurchaseOrderPurchaseReceiptsController extends Controller
{
    public function index(
        Request $request,
        PurchaseOrder $purchaseOrder
    ): PurchaseReceiptCollection {
        $this->authorize('view', $purchaseOrder);

        $search = $request->get('search', '');

        $purchaseReceipts = $purchaseOrder
            ->purchaseReceipts()
            ->search($search)
            ->latest()
            ->paginate();

        return new PurchaseReceiptCollection($purchaseReceipts);
    }

    public function store(
        Request $request,
        PurchaseOrder $purchaseOrder,
        PurchaseReceipt $purchaseReceipt
    ): Response {
        $this->authorize('update', $purchaseOrder);

        $purchaseOrder
            ->purchaseReceipts()
            ->syncWithoutDetaching([$purchaseReceipt->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        PurchaseOrder $purchaseOrder,
        PurchaseReceipt $purchaseReceipt
    ): Response {
        $this->authorize('update', $purchaseOrder);

        $purchaseOrder->purchaseReceipts()->detach($purchaseReceipt);

        return response()->noContent();
    }
}
