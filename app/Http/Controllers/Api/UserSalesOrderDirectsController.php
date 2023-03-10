<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SalesOrderDirectResource;
use App\Http\Resources\SalesOrderDirectCollection;

class UserSalesOrderDirectsController extends Controller
{
    public function index(
        Request $request,
        User $user
    ): SalesOrderDirectCollection {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $salesOrderDirects = $user
            ->salesOrderDirectOrders()
            ->search($search)
            ->latest()
            ->paginate();

        return new SalesOrderDirectCollection($salesOrderDirects);
    }

    public function store(
        Request $request,
        User $user
    ): SalesOrderDirectResource {
        $this->authorize('create', SalesOrderDirect::class);

        $validated = $request->validate([
            'delivery_date' => ['required', 'date'],
            'delivery_service_id' => [
                'required',
                'exists:delivery_services,id',
            ],
            'delivery_location_id' => [
                'nullable',
                'exists:delivery_locations,id',
            ],
            'transfer_to_account_id' => [
                'required',
                'exists:transfer_to_accounts,id',
            ],
            'payment_status' => ['required', 'max:255'],
            'image_transfer' => ['image', 'nullable'],
            'store_id' => ['nullable', 'exists:stores,id'],
            'received_by' => ['nullable', 'max:255', 'string'],
            'delivery_status' => ['required', 'max:255'],
            'notes' => ['nullable', 'max:255', 'string'],
            'image_receipt' => ['image', 'nullable'],
            'sign' => ['image', 'nullable'],
            'shipping_cost' => ['nullable', 'numeric'],
            'discounts' => ['nullable', 'numeric'],
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

        $salesOrderDirect = $user->salesOrderDirectOrders()->create($validated);

        return new SalesOrderDirectResource($salesOrderDirect);
    }
}
