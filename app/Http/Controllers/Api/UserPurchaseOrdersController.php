<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PurchaseOrderResource;
use App\Http\Resources\PurchaseOrderCollection;

class UserPurchaseOrdersController extends Controller
{
    public function index(Request $request, User $user): PurchaseOrderCollection
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $purchaseOrders = $user
            ->purchaseOrdersApproved()
            ->search($search)
            ->latest()
            ->paginate();

        return new PurchaseOrderCollection($purchaseOrders);
    }

    public function store(Request $request, User $user): PurchaseOrderResource
    {
        $this->authorize('create', PurchaseOrder::class);

        $validated = $request->validate([
            'image' => ['nullable', 'image'],
            'store_id' => ['required', 'exists:stores,id'],
            'supplier_id' => ['required', 'exists:suppliers,id'],
            'payment_type_id' => ['required', 'exists:payment_types,id'],
            'date' => ['required', 'date'],
            'taxes' => ['required', 'numeric', 'min:0'],
            'discounts' => ['required', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string', 'max:255'],
            'payment_status' => ['required'],
            'order_status' => ['required'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $purchaseOrder = $user->purchaseOrdersApproved()->create($validated);

        return new PurchaseOrderResource($purchaseOrder);
    }
}
