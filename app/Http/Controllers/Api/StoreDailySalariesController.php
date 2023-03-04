<?php

namespace App\Http\Controllers\Api;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DailySalaryResource;
use App\Http\Resources\DailySalaryCollection;

class StoreDailySalariesController extends Controller
{
    public function index(Request $request, Store $store): DailySalaryCollection
    {
        $this->authorize('view', $store);

        $search = $request->get('search', '');

        $dailySalaries = $store
            ->dailySalaries()
            ->search($search)
            ->latest()
            ->paginate();

        return new DailySalaryCollection($dailySalaries);
    }

    public function store(Request $request, Store $store): DailySalaryResource
    {
        $this->authorize('create', DailySalary::class);

        $validated = $request->validate([
            'shift_store_id' => ['required', 'exists:shift_stores,id'],
            'date' => ['required', 'date'],
            'amount' => ['required', 'numeric', 'gt:0'],
            'payment_type_id' => ['required', 'exists:payment_types,id'],
            'status' => ['required', 'in:1,2,3,4'],
            'presence_id' => ['nullable', 'exists:presences,id'],
        ]);

        $dailySalary = $store->dailySalaries()->create($validated);

        return new DailySalaryResource($dailySalary);
    }
}
