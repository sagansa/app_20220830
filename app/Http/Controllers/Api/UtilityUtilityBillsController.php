<?php

namespace App\Http\Controllers\Api;

use App\Models\Utility;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UtilityBillResource;
use App\Http\Resources\UtilityBillCollection;

class UtilityUtilityBillsController extends Controller
{
    public function index(
        Request $request,
        Utility $utility
    ): UtilityBillCollection {
        $this->authorize('view', $utility);

        $search = $request->get('search', '');

        $utilityBills = $utility
            ->utilityBills()
            ->search($search)
            ->latest()
            ->paginate();

        return new UtilityBillCollection($utilityBills);
    }

    public function store(
        Request $request,
        Utility $utility
    ): UtilityBillResource {
        $this->authorize('create', UtilityBill::class);

        $validated = $request->validate([
            'image' => ['nullable', 'image'],
            'date' => ['required', 'date'],
            'amount' => ['nullable', 'numeric', 'gt:0'],
            'initial_indicator' => ['nullable', 'numeric', 'gt:0'],
            'last_indicator' => ['required', 'numeric'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $utilityBill = $utility->utilityBills()->create($validated);

        return new UtilityBillResource($utilityBill);
    }
}
