<?php
namespace App\Http\Controllers\Api;

use App\Models\DailySalary;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\PaymentReceipt;
use App\Http\Controllers\Controller;
use App\Http\Resources\DailySalaryCollection;

class PaymentReceiptDailySalariesController extends Controller
{
    public function index(
        Request $request,
        PaymentReceipt $paymentReceipt
    ): DailySalaryCollection {
        $this->authorize('view', $paymentReceipt);

        $search = $request->get('search', '');

        $dailySalaries = $paymentReceipt
            ->dailySalaries()
            ->search($search)
            ->latest()
            ->paginate();

        return new DailySalaryCollection($dailySalaries);
    }

    public function store(
        Request $request,
        PaymentReceipt $paymentReceipt,
        DailySalary $dailySalary
    ): Response {
        $this->authorize('update', $paymentReceipt);

        $paymentReceipt
            ->dailySalaries()
            ->syncWithoutDetaching([$dailySalary->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        PaymentReceipt $paymentReceipt,
        DailySalary $dailySalary
    ): Response {
        $this->authorize('update', $paymentReceipt);

        $paymentReceipt->dailySalaries()->detach($dailySalary);

        return response()->noContent();
    }
}
