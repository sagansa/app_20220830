<?php
namespace App\Http\Controllers\Api;

use App\Models\FuelService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\PaymentReceipt;
use App\Http\Controllers\Controller;
use App\Http\Resources\FuelServiceCollection;

class PaymentReceiptFuelServicesController extends Controller
{
    public function index(
        Request $request,
        PaymentReceipt $paymentReceipt
    ): FuelServiceCollection {
        $this->authorize('view', $paymentReceipt);

        $search = $request->get('search', '');

        $fuelServices = $paymentReceipt
            ->fuelServices()
            ->search($search)
            ->latest()
            ->paginate();

        return new FuelServiceCollection($fuelServices);
    }

    public function store(
        Request $request,
        PaymentReceipt $paymentReceipt,
        FuelService $fuelService
    ): Response {
        $this->authorize('update', $paymentReceipt);

        $paymentReceipt
            ->fuelServices()
            ->syncWithoutDetaching([$fuelService->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        PaymentReceipt $paymentReceipt,
        FuelService $fuelService
    ): Response {
        $this->authorize('update', $paymentReceipt);

        $paymentReceipt->fuelServices()->detach($fuelService);

        return response()->noContent();
    }
}
