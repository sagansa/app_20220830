<?php

namespace App\Http\Controllers\Api;

use App\Models\PaymentType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\InvoicePurchaseResource;
use App\Http\Resources\InvoicePurchaseCollection;

class PaymentTypeInvoicePurchasesController extends Controller
{
    public function index(
        Request $request,
        PaymentType $paymentType
    ): InvoicePurchaseCollection {
        $this->authorize('view', $paymentType);

        $search = $request->get('search', '');

        $invoicePurchases = $paymentType
            ->invoicePurchases()
            ->search($search)
            ->latest()
            ->paginate();

        return new InvoicePurchaseCollection($invoicePurchases);
    }

    public function store(
        Request $request,
        PaymentType $paymentType
    ): InvoicePurchaseResource {
        $this->authorize('create', InvoicePurchase::class);

        $validated = $request->validate([
            'image' => ['nullable', 'image'],
            'store_id' => ['required', 'exists:stores,id'],
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

        $invoicePurchase = $paymentType->invoicePurchases()->create($validated);

        return new InvoicePurchaseResource($invoicePurchase);
    }
}
