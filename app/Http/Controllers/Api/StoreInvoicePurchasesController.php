<?php

namespace App\Http\Controllers\Api;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\InvoicePurchaseResource;
use App\Http\Resources\InvoicePurchaseCollection;

class StoreInvoicePurchasesController extends Controller
{
    public function index(
        Request $request,
        Store $store
    ): InvoicePurchaseCollection {
        $this->authorize('view', $store);

        $search = $request->get('search', '');

        $invoicePurchases = $store
            ->invoicePurchases()
            ->search($search)
            ->latest()
            ->paginate();

        return new InvoicePurchaseCollection($invoicePurchases);
    }

    public function store(
        Request $request,
        Store $store
    ): InvoicePurchaseResource {
        $this->authorize('create', InvoicePurchase::class);

        $validated = $request->validate([
            'image' => ['nullable', 'image'],
            'payment_type_id' => ['required', 'exists:payment_types,id'],
            'supplier_id' => ['required', 'exists:suppliers,id'],
            'date' => ['required', 'date'],
            'discounts' => ['required', 'numeric', 'min:0'],
            'taxes' => ['required', 'numeric', 'min:0'],
            'payment_status' => ['required', 'in:1,2,3,4'],
            'order_status' => ['required', 'in:1,2,3'],
            'notes' => ['nullable', 'max:255', 'string'],
            'created_by_id' => ['nullable', 'exists:users,id'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $invoicePurchase = $store->invoicePurchases()->create($validated);

        return new InvoicePurchaseResource($invoicePurchase);
    }
}
