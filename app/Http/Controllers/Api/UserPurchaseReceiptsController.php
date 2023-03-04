<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PurchaseReceiptResource;
use App\Http\Resources\PurchaseReceiptCollection;

class UserPurchaseReceiptsController extends Controller
{
    public function index(
        Request $request,
        User $user
    ): PurchaseReceiptCollection {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $purchaseReceipts = $user
            ->purchaseReceipts()
            ->search($search)
            ->latest()
            ->paginate();

        return new PurchaseReceiptCollection($purchaseReceipts);
    }

    public function store(Request $request, User $user): PurchaseReceiptResource
    {
        $this->authorize('create', PurchaseReceipt::class);

        $validated = $request->validate([
            'image' => ['nullable', 'image'],
            'nominal_transfer' => ['nullable', 'max:255'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $purchaseReceipt = $user->purchaseReceipts()->create($validated);

        return new PurchaseReceiptResource($purchaseReceipt);
    }
}
