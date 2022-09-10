<?php
namespace App\Http\Controllers\Api;

use App\Models\DailySalary;
use Illuminate\Http\Request;
use App\Models\PaymentReceipt;
use App\Http\Controllers\Controller;
use App\Http\Resources\DailySalaryCollection;

class PaymentReceiptDailySalariesController extends Controller
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

        $dailySalaries = $paymentReceipt
            ->dailySalaries()
            ->search($search)
            ->latest()
            ->paginate();

        return new DailySalaryCollection($dailySalaries);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PaymentReceipt $paymentReceipt
     * @param \App\Models\DailySalary $dailySalary
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        PaymentReceipt $paymentReceipt,
        DailySalary $dailySalary
    ) {
        $this->authorize('update', $paymentReceipt);

        $paymentReceipt
            ->dailySalaries()
            ->syncWithoutDetaching([$dailySalary->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PaymentReceipt $paymentReceipt
     * @param \App\Models\DailySalary $dailySalary
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        PaymentReceipt $paymentReceipt,
        DailySalary $dailySalary
    ) {
        $this->authorize('update', $paymentReceipt);

        $paymentReceipt->dailySalaries()->detach($dailySalary);

        return response()->noContent();
    }
}
