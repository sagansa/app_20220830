<?php
namespace App\Http\Controllers\Api;

use App\Models\DailySalary;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\PaymentReceipt;
use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentReceiptCollection;

class DailySalaryPaymentReceiptsController extends Controller
{
    public function index(
        Request $request,
        DailySalary $dailySalary
    ): PaymentReceiptCollection {
        $this->authorize('view', $dailySalary);

        $search = $request->get('search', '');

        $paymentReceipts = $dailySalary
            ->paymentReceipts()
            ->search($search)
            ->latest()
            ->paginate();

        return new PaymentReceiptCollection($paymentReceipts);
    }

    public function store(
        Request $request,
        DailySalary $dailySalary,
        PaymentReceipt $paymentReceipt
    ): Response {
        $this->authorize('update', $dailySalary);

        $dailySalary
            ->paymentReceipts()
            ->syncWithoutDetaching([$paymentReceipt->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        DailySalary $dailySalary,
        PaymentReceipt $paymentReceipt
    ): Response {
        $this->authorize('update', $dailySalary);

        $dailySalary->paymentReceipts()->detach($paymentReceipt);

        return response()->noContent();
    }
}
