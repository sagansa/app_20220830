<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\InvoicePurchaseResource;
use App\Http\Resources\InvoicePurchaseCollection;

class UserInvoicePurchasesController extends Controller
{
    public function index(
        Request $request,
        User $user
    ): InvoicePurchaseCollection {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $invoicePurchases = $user
            ->invoicePurchasesCreated()
            ->search($search)
            ->latest()
            ->paginate();

        return new InvoicePurchaseCollection($invoicePurchases);
    }

    public function store(Request $request, User $user): InvoicePurchaseResource
    {
        $this->authorize('create', InvoicePurchase::class);

        $validated = $request->validate([
            'image' => ['nullable', 'image'],
            'payment_type_id' => ['required', 'exists:payment_types,id'],
            'store_id' => ['required', 'exists:stores,id'],
            'supplier_id' => ['required', 'exists:suppliers,id'],
            'date' => ['required', 'date'],
            'discounts' => ['required', 'numeric', 'min:0'],
            'taxes' => ['required', 'numeric', 'min:0'],
            'payment_status' => ['required', 'in:1,2,3,4'],
            'order_status' => ['required', 'in:1,2,3'],
            'notes' => ['nullable', 'max:255', 'string'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $invoicePurchase = $user->invoicePurchasesCreated()->create($validated);

        return new InvoicePurchaseResource($invoicePurchase);
    }
}
