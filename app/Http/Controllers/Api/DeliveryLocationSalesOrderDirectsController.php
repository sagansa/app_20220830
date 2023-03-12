<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\DeliveryLocation;
use App\Http\Controllers\Controller;
use App\Http\Resources\SalesOrderDirectResource;
use App\Http\Resources\SalesOrderDirectCollection;

class DeliveryLocationSalesOrderDirectsController extends Controller
{
    public function index(
        Request $request,
        DeliveryLocation $deliveryLocation
    ): SalesOrderDirectCollection {
        $this->authorize('view', $deliveryLocation);

        $search = $request->get('search', '');

        $salesOrderDirects = $deliveryLocation
            ->salesOrderDirects()
            ->search($search)
            ->latest()
            ->paginate();

        return new SalesOrderDirectCollection($salesOrderDirects);
    }

    public function store(
        Request $request,
        DeliveryLocation $deliveryLocation
    ): SalesOrderDirectResource {
        $this->authorize('create', SalesOrderDirect::class);

        $validated = $request->validate([
            'order_by_id' => ['nullable', 'exists:users,id'],
            'delivery_date' => ['required', 'date'],
            'delivery_service_id' => [
                'required',
                'exists:delivery_services,id',
            ],
            'transfer_to_account_id' => [
                'required',
                'exists:transfer_to_accounts,id',
            ],
            'payment_status' => ['required', 'max:255'],
            'image_transfer' => ['image', 'nullable'],
            'store_id' => ['nullable', 'exists:stores,id'],
            'submitted_by_id' => ['nullable', 'exists:users,id'],
            'received_by' => ['nullable', 'max:255', 'string'],
            'delivery_status' => ['required', 'max:255'],
            'notes' => ['nullable', 'max:255', 'string'],
            'image_receipt' => ['image', 'nullable'],
            'sign' => ['image', 'nullable'],
            'shipping_cost' => ['nullable', 'numeric'],
            'discounts' => ['nullable', 'numeric'],
            'coupon_id' => ['nullable', 'exists:coupons,id'],
        ]);

        if ($request->hasFile('image_transfer')) {
            $validated['image_transfer'] = $request
                ->file('image_transfer')
                ->store('public');
        }

        if ($request->hasFile('image_receipt')) {
            $validated['image_receipt'] = $request
                ->file('image_receipt')
                ->store('public');
        }

        if ($request->hasFile('sign')) {
            $validated['sign'] = $request->file('sign')->store('public');
        }

        $salesOrderDirect = $deliveryLocation
            ->salesOrderDirects()
            ->create($validated);

        return new SalesOrderDirectResource($salesOrderDirect);
    }
}
