<?php
namespace App\Http\Controllers\Api;

use App\Models\DailySalary;
use Illuminate\Http\Request;
use App\Models\PaymentReceipt;
use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentReceiptCollection;

class DailySalaryPaymentReceiptsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DailySalary $dailySalary
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, DailySalary $dailySalary)
    {
        $this->authorize('view', $dailySalary);

        $search = $request->get('search', '');

        $paymentReceipts = $dailySalary
            ->paymentReceipts()
            ->search($search)
            ->latest()
            ->paginate();

        return new PaymentReceiptCollection($paymentReceipts);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DailySalary $dailySalary
     * @param \App\Models\PaymentReceipt $paymentReceipt
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        DailySalary $dailySalary,
        PaymentReceipt $paymentReceipt
    ) {
        $this->authorize('update', $dailySalary);

        $dailySalary
            ->paymentReceipts()
            ->syncWithoutDetaching([$paymentReceipt->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DailySalary $dailySalary
     * @param \App\Models\PaymentReceipt $paymentReceipt
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        DailySalary $dailySalary,
        PaymentReceipt $paymentReceipt
    ) {
        $this->authorize('update', $dailySalary);

        $dailySalary->paymentReceipts()->detach($paymentReceipt);

        return response()->noContent();
    }
}
