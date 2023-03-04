<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\PaymentReceipt;
use App\Models\InvoicePurchase;
use App\Http\Controllers\Controller;
use App\Http\Resources\InvoicePurchaseCollection;

class PaymentReceiptInvoicePurchasesController extends Controller
{
    public function index(
        Request $request,
        PaymentReceipt $paymentReceipt
    ): InvoicePurchaseCollection {
        $this->authorize('view', $paymentReceipt);

        $search = $request->get('search', '');

        $invoicePurchases = $paymentReceipt
            ->invoicePurchases()
            ->search($search)
            ->latest()
            ->paginate();

        return new InvoicePurchaseCollection($invoicePurchases);
    }

    public function store(
        Request $request,
        PaymentReceipt $paymentReceipt,
        InvoicePurchase $invoicePurchase
    ): Response {
        $this->authorize('update', $paymentReceipt);

        $paymentReceipt
            ->invoicePurchases()
            ->syncWithoutDetaching([$invoicePurchase->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        PaymentReceipt $paymentReceipt,
        InvoicePurchase $invoicePurchase
    ): Response {
        $this->authorize('update', $paymentReceipt);

        $paymentReceipt->invoicePurchases()->detach($invoicePurchase);

        return response()->noContent();
    }
}
