<?php

namespace App\Http\Controllers\Api;

use App\Models\UtilityBill;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\UtilityBillResource;
use App\Http\Resources\UtilityBillCollection;
use App\Http\Requests\UtilityBillStoreRequest;
use App\Http\Requests\UtilityBillUpdateRequest;

class UtilityBillController extends Controller
{
    public function index(Request $request): UtilityBillCollection
    {
        $this->authorize('view-any', UtilityBill::class);

        $search = $request->get('search', '');

        $utilityBills = UtilityBill::search($search)
            ->latest()
            ->paginate();

        return new UtilityBillCollection($utilityBills);
    }

    public function store(UtilityBillStoreRequest $request): UtilityBillResource
    {
        $this->authorize('create', UtilityBill::class);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $utilityBill = UtilityBill::create($validated);

        return new UtilityBillResource($utilityBill);
    }

    public function show(
        Request $request,
        UtilityBill $utilityBill
    ): UtilityBillResource {
        $this->authorize('view', $utilityBill);

        return new UtilityBillResource($utilityBill);
    }

    public function update(
        UtilityBillUpdateRequest $request,
        UtilityBill $utilityBill
    ): UtilityBillResource {
        $this->authorize('update', $utilityBill);

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($utilityBill->image) {
                Storage::delete($utilityBill->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        $utilityBill->update($validated);

        return new UtilityBillResource($utilityBill);
    }

    public function destroy(
        Request $request,
        UtilityBill $utilityBill
    ): Response {
        $this->authorize('delete', $utilityBill);

        if ($utilityBill->image) {
            Storage::delete($utilityBill->image);
        }

        $utilityBill->delete();

        return response()->noContent();
    }
}
