<?php

namespace App\Http\Controllers\Api;

use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\InvoicePurchaseResource;
use App\Http\Resources\InvoicePurchaseCollection;

class SupplierInvoicePurchasesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Supplier $supplier
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Supplier $supplier)
    {
        $this->authorize('view', $supplier);

        $search = $request->get('search', '');

        $invoicePurchases = $supplier
            ->invoicePurchases()
            ->search($search)
            ->latest()
            ->paginate();

        return new InvoicePurchaseCollection($invoicePurchases);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Supplier $supplier
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Supplier $supplier)
    {
        $this->authorize('create', InvoicePurchase::class);

        $validated = $request->validate([
            'image' => ['nullable', 'image'],
            'payment_type_id' => ['required', 'exists:payment_types,id'],
            'store_id' => ['required', 'exists:stores,id'],
            'date' => ['required', 'date'],
            'payment_status' => ['required'],
            'order_status' => ['required'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $invoicePurchase = $supplier->invoicePurchases()->create($validated);

        return new InvoicePurchaseResource($invoicePurchase);
    }
}
