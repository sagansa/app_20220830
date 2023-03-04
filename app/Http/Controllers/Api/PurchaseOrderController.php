<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\PurchaseOrder;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\PurchaseOrderResource;
use App\Http\Resources\PurchaseOrderCollection;
use App\Http\Requests\PurchaseOrderStoreRequest;
use App\Http\Requests\PurchaseOrderUpdateRequest;

class PurchaseOrderController extends Controller
{
    public function index(Request $request): PurchaseOrderCollection
    {
        $this->authorize('view-any', PurchaseOrder::class);

        $search = $request->get('search', '');

        $purchaseOrders = PurchaseOrder::search($search)
            ->latest()
            ->paginate();

        return new PurchaseOrderCollection($purchaseOrders);
    }

    public function store(
        PurchaseOrderStoreRequest $request
    ): PurchaseOrderResource {
        $this->authorize('create', PurchaseOrder::class);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $purchaseOrder = PurchaseOrder::create($validated);

        return new PurchaseOrderResource($purchaseOrder);
    }

    public function show(
        Request $request,
        PurchaseOrder $purchaseOrder
    ): PurchaseOrderResource {
        $this->authorize('view', $purchaseOrder);

        return new PurchaseOrderResource($purchaseOrder);
    }

    public function update(
        PurchaseOrderUpdateRequest $request,
        PurchaseOrder $purchaseOrder
    ): PurchaseOrderResource {
        $this->authorize('update', $purchaseOrder);

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($purchaseOrder->image) {
                Storage::delete($purchaseOrder->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        $purchaseOrder->update($validated);

        return new PurchaseOrderResource($purchaseOrder);
    }

    public function destroy(
        Request $request,
        PurchaseOrder $purchaseOrder
    ): Response {
        $this->authorize('delete', $purchaseOrder);

        if ($purchaseOrder->image) {
            Storage::delete($purchaseOrder->image);
        }

        $purchaseOrder->delete();

        return response()->noContent();
    }
}
