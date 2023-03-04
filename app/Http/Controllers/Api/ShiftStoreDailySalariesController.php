<?php

namespace App\Http\Controllers\Api;

use App\Models\ShiftStore;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DailySalaryResource;
use App\Http\Resources\DailySalaryCollection;

class ShiftStoreDailySalariesController extends Controller
{
    public function index(
        Request $request,
        ShiftStore $shiftStore
    ): DailySalaryCollection {
        $this->authorize('view', $shiftStore);

        $search = $request->get('search', '');

        $dailySalaries = $shiftStore
            ->dailySalaries()
            ->search($search)
            ->latest()
            ->paginate();

        return new DailySalaryCollection($dailySalaries);
    }

    public function store(
        Request $request,
        ShiftStore $shiftStore
    ): DailySalaryResource {
        $this->authorize('create', DailySalary::class);

        $validated = $request->validate([
            'store_id' => ['required', 'exists:stores,id'],
            'date' => ['required', 'date'],
            'amount' => ['required', 'numeric', 'gt:0'],
            'payment_type_id' => ['required', 'exists:payment_types,id'],
            'status' => ['required', 'in:1,2,3,4'],
            'presence_id' => ['nullable', 'exists:presences,id'],
        ]);

        $dailySalary = $shiftStore->dailySalaries()->create($validated);

        return new DailySalaryResource($dailySalary);
    }
}
