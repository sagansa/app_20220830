<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\TransferToAccount;
use App\Http\Controllers\Controller;
use App\Http\Resources\SalesOrderDirectResource;
use App\Http\Resources\SalesOrderDirectCollection;

class TransferToAccountSalesOrderDirectsController extends Controller
{
    public function index(
        Request $request,
        TransferToAccount $transferToAccount
    ): SalesOrderDirectCollection {
        $this->authorize('view', $transferToAccount);

        $search = $request->get('search', '');

        $salesOrderDirects = $transferToAccount
            ->salesOrderDirects()
            ->search($search)
            ->latest()
            ->paginate();

        return new SalesOrderDirectCollection($salesOrderDirects);
    }

    public function store(
        Request $request,
        TransferToAccount $transferToAccount
    ): SalesOrderDirectResource {
        $this->authorize('create', SalesOrderDirect::class);

        $validated = $request->validate([
            'order_by_id' => ['required', 'exists:users,id'],
            'delivery_date' => ['required', 'date'],
            'delivery_service_id' => [
                'required',
                'exists:delivery_services,id',
            ],
            'image_transfer' => ['image', 'nullable'],
            'payment_status' => ['required'],
            'store_id' => ['nullable', 'exists:stores,id'],
            'submitted_by_id' => ['nullable', 'exists:users,id'],
            'received_by' => ['nullable', 'max:255', 'string'],
            'sign' => ['image', 'nullable'],
            'image_receipt' => ['image', 'nullable'],
            'delivery_status' => ['required'],
            'shipping_cost' => ['nullable'],
            'Discounts' => ['required', 'max:255'],
        ]);

        if ($request->hasFile('image_transfer')) {
            $validated['image_transfer'] = $request
                ->file('image_transfer')
                ->store('public');
        }

        if ($request->hasFile('sign')) {
            $validated['sign'] = $request->file('sign')->store('public');
        }

        if ($request->hasFile('image_receipt')) {
            $validated['image_receipt'] = $request
                ->file('image_receipt')
                ->store('public');
        }

        $salesOrderDirect = $transferToAccount
            ->salesOrderDirects()
            ->create($validated);

        return new SalesOrderDirectResource($salesOrderDirect);
    }
}
