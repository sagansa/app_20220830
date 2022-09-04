<?php

namespace App\Http\Controllers\Api;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\InvoicePurchaseResource;
use App\Http\Resources\InvoicePurchaseCollection;

class StoreInvoicePurchasesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Store $store
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Store $store)
    {
        $this->authorize('view', $store);

        $search = $request->get('search', '');

        $invoicePurchases = $store
            ->invoicePurchases()
            ->search($search)
            ->latest()
            ->paginate();

        return new InvoicePurchaseCollection($invoicePurchases);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Store $store
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Store $store)
    {
        $this->authorize('create', InvoicePurchase::class);

        $validated = $request->validate([
            'image' => ['nullable', 'image'],
            'payment_type_id' => ['required', 'exists:payment_types,id'],
            'supplier_id' => ['required', 'exists:suppliers,id'],
            'date' => ['required', 'date'],
            'payment_status' => ['required'],
            'order_status' => ['required'],
            'created_by_id' => ['nullable', 'exists:users,id'],
            'approved_id' => ['nullable', 'exists:users,id'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $invoicePurchase = $store->invoicePurchases()->create($validated);

        return new InvoicePurchaseResource($invoicePurchase);
    }
}
