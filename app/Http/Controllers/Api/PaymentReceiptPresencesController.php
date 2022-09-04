<?php
namespace App\Http\Controllers\Api;

use App\Models\Presence;
use Illuminate\Http\Request;
use App\Models\PaymentReceipt;
use App\Http\Controllers\Controller;
use App\Http\Resources\PresenceCollection;

class PaymentReceiptPresencesController extends Controller
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

        $presences = $paymentReceipt
            ->presences()
            ->search($search)
            ->latest()
            ->paginate();

        return new PresenceCollection($presences);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PaymentReceipt $paymentReceipt
     * @param \App\Models\Presence $presence
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        PaymentReceipt $paymentReceipt,
        Presence $presence
    ) {
        $this->authorize('update', $paymentReceipt);

        $paymentReceipt->presences()->syncWithoutDetaching([$presence->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PaymentReceipt $paymentReceipt
     * @param \App\Models\Presence $presence
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        PaymentReceipt $paymentReceipt,
        Presence $presence
    ) {
        $this->authorize('update', $paymentReceipt);

        $paymentReceipt->presences()->detach($presence);

        return response()->noContent();
    }
}
