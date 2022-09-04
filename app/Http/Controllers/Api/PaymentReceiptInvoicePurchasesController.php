<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\PaymentReceipt;
use App\Models\InvoicePurchase;
use App\Http\Controllers\Controller;
use App\Http\Resources\InvoicePurchaseCollection;

class PaymentReceiptInvoicePurchasesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PaymentReceipt $paymentReceipt
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, PaymentReceipt $paymentReceipt)
    {
        $this->authorize('view', $paymentReceipt);

        $search = $request->get('search', '');

        $invoicePurchases = $paymentReceipt
            ->invoicePurchases()
            ->search($search)
            ->latest()
            ->paginate();

        return new InvoicePurchaseCollection($invoicePurchases);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PaymentReceipt $paymentReceipt
     * @param \App\Models\InvoicePurchase $invoicePurchase
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        PaymentReceipt $paymentReceipt,
        InvoicePurchase $invoicePurchase
    ) {
        $this->authorize('update', $paymentReceipt);

        $paymentReceipt
            ->invoicePurchases()
            ->syncWithoutDetaching([$invoicePurchase->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PaymentReceipt $paymentReceipt
     * @param \App\Models\InvoicePurchase $invoicePurchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        PaymentReceipt $paymentReceipt,
        InvoicePurchase $invoicePurchase
    ) {
        $this->authorize('update', $paymentReceipt);

        $paymentReceipt->invoicePurchases()->detach($invoicePurchase);

        return response()->noContent();
    }
}
