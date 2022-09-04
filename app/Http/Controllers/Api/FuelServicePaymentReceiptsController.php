<?php
namespace App\Http\Controllers\Api;

use App\Models\FuelService;
use Illuminate\Http\Request;
use App\Models\PaymentReceipt;
use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentReceiptCollection;

class FuelServicePaymentReceiptsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FuelService $fuelService
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, FuelService $fuelService)
    {
        $this->authorize('view', $fuelService);

        $search = $request->get('search', '');

        $paymentReceipts = $fuelService
            ->paymentReceipts()
            ->search($search)
            ->latest()
            ->paginate();

        return new PaymentReceiptCollection($paymentReceipts);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FuelService $fuelService
     * @param \App\Models\PaymentReceipt $paymentReceipt
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        FuelService $fuelService,
        PaymentReceipt $paymentReceipt
    ) {
        $this->authorize('update', $fuelService);

        $fuelService
            ->paymentReceipts()
            ->syncWithoutDetaching([$paymentReceipt->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FuelService $fuelService
     * @param \App\Models\PaymentReceipt $paymentReceipt
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        FuelService $fuelService,
        PaymentReceipt $paymentReceipt
    ) {
        $this->authorize('update', $fuelService);

        $fuelService->paymentReceipts()->detach($paymentReceipt);

        return response()->noContent();
    }
}
