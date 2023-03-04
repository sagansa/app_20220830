<?php
namespace App\Http\Controllers\Api;

use App\Models\FuelService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\PaymentReceipt;
use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentReceiptCollection;

class FuelServicePaymentReceiptsController extends Controller
{
    public function index(
        Request $request,
        FuelService $fuelService
    ): PaymentReceiptCollection {
        $this->authorize('view', $fuelService);

        $search = $request->get('search', '');

        $paymentReceipts = $fuelService
            ->paymentReceipts()
            ->search($search)
            ->latest()
            ->paginate();

        return new PaymentReceiptCollection($paymentReceipts);
    }

    public function store(
        Request $request,
        FuelService $fuelService,
        PaymentReceipt $paymentReceipt
    ): Response {
        $this->authorize('update', $fuelService);

        $fuelService
            ->paymentReceipts()
            ->syncWithoutDetaching([$paymentReceipt->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        FuelService $fuelService,
        PaymentReceipt $paymentReceipt
    ): Response {
        $this->authorize('update', $fuelService);

        $fuelService->paymentReceipts()->detach($paymentReceipt);

        return response()->noContent();
    }
}
