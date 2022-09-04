<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\InvoicePurchase;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\InvoicePurchaseResource;
use App\Http\Resources\InvoicePurchaseCollection;
use App\Http\Requests\InvoicePurchaseStoreRequest;
use App\Http\Requests\InvoicePurchaseUpdateRequest;

class InvoicePurchaseController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', InvoicePurchase::class);

        $search = $request->get('search', '');

        $invoicePurchases = InvoicePurchase::search($search)
            ->latest()
            ->paginate();

        return new InvoicePurchaseCollection($invoicePurchases);
    }

    /**
     * @param \App\Http\Requests\InvoicePurchaseStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(InvoicePurchaseStoreRequest $request)
    {
        $this->authorize('create', InvoicePurchase::class);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $invoicePurchase = InvoicePurchase::create($validated);

        return new InvoicePurchaseResource($invoicePurchase);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\InvoicePurchase $invoicePurchase
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, InvoicePurchase $invoicePurchase)
    {
        $this->authorize('view', $invoicePurchase);

        return new InvoicePurchaseResource($invoicePurchase);
    }

    /**
     * @param \App\Http\Requests\InvoicePurchaseUpdateRequest $request
     * @param \App\Models\InvoicePurchase $invoicePurchase
     * @return \Illuminate\Http\Response
     */
    public function update(
        InvoicePurchaseUpdateRequest $request,
        InvoicePurchase $invoicePurchase
    ) {
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

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\InvoicePurchase $invoicePurchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, InvoicePurchase $invoicePurchase)
    {
        $this->authorize('delete', $invoicePurchase);

        if ($invoicePurchase->image) {
            Storage::delete($invoicePurchase->image);
        }

        $invoicePurchase->delete();

        return response()->noContent();
    }
}
