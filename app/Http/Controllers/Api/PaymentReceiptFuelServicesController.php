<?php
namespace App\Http\Controllers\Api;

use App\Models\FuelService;
use Illuminate\Http\Request;
use App\Models\PaymentReceipt;
use App\Http\Controllers\Controller;
use App\Http\Resources\FuelServiceCollection;

class PaymentReceiptFuelServicesController extends Controller
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

        $fuelServices = $paymentReceipt
            ->fuelServices()
            ->search($search)
            ->latest()
            ->paginate();

        return new FuelServiceCollection($fuelServices);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PaymentReceipt $paymentReceipt
     * @param \App\Models\FuelService $fuelService
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        PaymentReceipt $paymentReceipt,
        FuelService $fuelService
    ) {
        $this->authorize('update', $paymentReceipt);

        $paymentReceipt
            ->fuelServices()
            ->syncWithoutDetaching([$fuelService->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PaymentReceipt $paymentReceipt
     * @param \App\Models\FuelService $fuelService
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        PaymentReceipt $paymentReceipt,
        FuelService $fuelService
    ) {
        $this->authorize('update', $paymentReceipt);

        $paymentReceipt->fuelServices()->detach($fuelService);

        return response()->noContent();
    }
}
