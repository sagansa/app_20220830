<?php
namespace App\Http\Controllers\Api;

use App\Models\Presence;
use Illuminate\Http\Request;
use App\Models\PaymentReceipt;
use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentReceiptCollection;

class PresencePaymentReceiptsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Presence $presence
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Presence $presence)
    {
        $this->authorize('view', $presence);

        $search = $request->get('search', '');

        $paymentReceipts = $presence
            ->paymentReceipts()
            ->search($search)
            ->latest()
            ->paginate();

        return new PaymentReceiptCollection($paymentReceipts);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Presence $presence
     * @param \App\Models\PaymentReceipt $paymentReceipt
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        Presence $presence,
        PaymentReceipt $paymentReceipt
    ) {
        $this->authorize('update', $presence);

        $presence
            ->paymentReceipts()
            ->syncWithoutDetaching([$paymentReceipt->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Presence $presence
     * @param \App\Models\PaymentReceipt $paymentReceipt
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        Presence $presence,
        PaymentReceipt $paymentReceipt
    ) {
        $this->authorize('update', $presence);

        $presence->paymentReceipts()->detach($paymentReceipt);

        return response()->noContent();
    }
}
