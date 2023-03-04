<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\PurchaseReceipt;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\PurchaseReceiptResource;
use App\Http\Resources\PurchaseReceiptCollection;
use App\Http\Requests\PurchaseReceiptStoreRequest;
use App\Http\Requests\PurchaseReceiptUpdateRequest;

class PurchaseReceiptController extends Controller
{
    public function index(Request $request): PurchaseReceiptCollection
    {
        $this->authorize('view-any', PurchaseReceipt::class);

        $search = $request->get('search', '');

        $purchaseReceipts = PurchaseReceipt::search($search)
            ->latest()
            ->paginate();

        return new PurchaseReceiptCollection($purchaseReceipts);
    }

    public function store(
        PurchaseReceiptStoreRequest $request
    ): PurchaseReceiptResource {
        $this->authorize('create', PurchaseReceipt::class);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $purchaseReceipt = PurchaseReceipt::create($validated);

        return new PurchaseReceiptResource($purchaseReceipt);
    }

    public function show(
        Request $request,
        PurchaseReceipt $purchaseReceipt
    ): PurchaseReceiptResource {
        $this->authorize('view', $purchaseReceipt);

        return new PurchaseReceiptResource($purchaseReceipt);
    }

    public function update(
        PurchaseReceiptUpdateRequest $request,
        PurchaseReceipt $purchaseReceipt
    ): PurchaseReceiptResource {
        $this->authorize('update', $purchaseReceipt);

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($purchaseReceipt->image) {
                Storage::delete($purchaseReceipt->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        $purchaseReceipt->update($validated);

        return new PurchaseReceiptResource($purchaseReceipt);
    }

    public function destroy(
        Request $request,
        PurchaseReceipt $purchaseReceipt
    ): Response {
        $this->authorize('delete', $purchaseReceipt);

        if ($purchaseReceipt->image) {
            Storage::delete($purchaseReceipt->image);
        }

        $purchaseReceipt->delete();

        return response()->noContent();
    }
}
