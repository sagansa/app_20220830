<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\PaymentReceipt;
use App\Models\InvoicePurchase;
use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentReceiptCollection;

class InvoicePurchasePaymentReceiptsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\InvoicePurchase $invoicePurchase
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, InvoicePurchase $invoicePurchase)
    {
        $this->authorize('view', $invoicePurchase);

        $search = $request->get('search', '');

        $paymentReceipts = $invoicePurchase
            ->paymentReceipts()
            ->search($search)
            ->latest()
            ->paginate();

        return new PaymentReceiptCollection($paymentReceipts);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\InvoicePurchase $invoicePurchase
     * @param \App\Models\PaymentReceipt $paymentReceipt
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        InvoicePurchase $invoicePurchase,
        PaymentReceipt $paymentReceipt
    ) {
        $this->authorize('update', $invoicePurchase);

        $invoicePurchase
            ->paymentReceipts()
            ->syncWithoutDetaching([$paymentReceipt->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\InvoicePurchase $invoicePurchase
     * @param \App\Models\PaymentReceipt $paymentReceipt
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        InvoicePurchase $invoicePurchase,
        PaymentReceipt $paymentReceipt
    ) {
        $this->authorize('update', $invoicePurchase);

        $invoicePurchase->paymentReceipts()->detach($paymentReceipt);

        return response()->noContent();
    }
}
