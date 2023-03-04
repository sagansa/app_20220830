<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\PaymentReceipt;
use App\Models\InvoicePurchase;
use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentReceiptCollection;

class InvoicePurchasePaymentReceiptsController extends Controller
{
    public function index(
        Request $request,
        InvoicePurchase $invoicePurchase
    ): PaymentReceiptCollection {
        $this->authorize('view', $invoicePurchase);

        $search = $request->get('search', '');

        $paymentReceipts = $invoicePurchase
            ->paymentReceipts()
            ->search($search)
            ->latest()
            ->paginate();

        return new PaymentReceiptCollection($paymentReceipts);
    }

    public function store(
        Request $request,
        InvoicePurchase $invoicePurchase,
        PaymentReceipt $paymentReceipt
    ): Response {
        $this->authorize('update', $invoicePurchase);

        $invoicePurchase
            ->paymentReceipts()
            ->syncWithoutDetaching([$paymentReceipt->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        InvoicePurchase $invoicePurchase,
        PaymentReceipt $paymentReceipt
    ): Response {
        $this->authorize('update', $invoicePurchase);

        $invoicePurchase->paymentReceipts()->detach($paymentReceipt);

        return response()->noContent();
    }
}
