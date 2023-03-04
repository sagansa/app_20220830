<?php

namespace App\Http\Controllers\Api;

use App\Models\PaymentType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DailySalaryResource;
use App\Http\Resources\DailySalaryCollection;

class PaymentTypeDailySalariesController extends Controller
{
    public function index(
        Request $request,
        PaymentType $paymentType
    ): DailySalaryCollection {
        $this->authorize('view', $paymentType);

        $search = $request->get('search', '');

        $dailySalaries = $paymentType
            ->dailySalaries()
            ->search($search)
            ->latest()
            ->paginate();

        return new DailySalaryCollection($dailySalaries);
    }

    public function store(
        Request $request,
        PaymentType $paymentType
    ): DailySalaryResource {
        $this->authorize('create', DailySalary::class);

        $validated = $request->validate([
            'store_id' => ['required', 'exists:stores,id'],
            'shift_store_id' => ['required', 'exists:shift_stores,id'],
            'date' => ['required', 'date'],
            'amount' => ['required', 'numeric', 'gt:0'],
            'status' => ['required', 'in:1,2,3,4'],
            'presence_id' => ['nullable', 'exists:presences,id'],
        ]);

        $dailySalary = $paymentType->dailySalaries()->create($validated);

        return new DailySalaryResource($dailySalary);
    }
}
