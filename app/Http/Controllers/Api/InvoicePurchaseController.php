<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\InvoicePurchase;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\InvoicePurchaseResource;
use App\Http\Resources\InvoicePurchaseCollection;
use App\Http\Requests\InvoicePurchaseStoreRequest;
use App\Http\Requests\InvoicePurchaseUpdateRequest;

class InvoicePurchaseController extends Controller
{
    public function index(Request $request): InvoicePurchaseCollection
    {
        $this->authorize('view-any', InvoicePurchase::class);

        $search = $request->get('search', '');

        $invoicePurchases = InvoicePurchase::search($search)
            ->latest()
            ->paginate();

        return new InvoicePurchaseCollection($invoicePurchases);
    }

    public function store(
        InvoicePurchaseStoreRequest $request
    ): InvoicePurchaseResource {
        $this->authorize('create', InvoicePurchase::class);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $invoicePurchase = InvoicePurchase::create($validated);

        return new InvoicePurchaseResource($invoicePurchase);
    }

    public function show(
        Request $request,
        InvoicePurchase $invoicePurchase
    ): InvoicePurchaseResource {
        $this->authorize('view', $invoicePurchase);

        return new InvoicePurchaseResource($invoicePurchase);
    }

    public function update(
        InvoicePurchaseUpdateRequest $request,
        InvoicePurchase $invoicePurchase
    ): InvoicePurchaseResource {
        $this->authorize('update', $invoicePurchase);

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($invoicePurchase->image) {
                Storage::delete($invoicePurchase->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        $invoicePurchase->update($validated);

        return new InvoicePurchaseResource($invoicePurchase);
    }

    public function destroy(
        Request $request,
        InvoicePurchase $invoicePurchase
    ): Response {
        $this->authorize('delete', $invoicePurchase);

        if ($invoicePurchase->image) {
            Storage::delete($invoicePurchase->image);
        }

        $invoicePurchase->delete();

        return response()->noContent();
    }
}
