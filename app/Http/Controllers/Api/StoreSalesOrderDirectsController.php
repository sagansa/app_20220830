<?php

namespace App\Http\Controllers\Api;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SalesOrderDirectResource;
use App\Http\Resources\SalesOrderDirectCollection;

class StoreSalesOrderDirectsController extends Controller
{
    public function index(
        Request $request,
        Store $store
    ): SalesOrderDirectCollection {
        $this->authorize('view', $store);

        $search = $request->get('search', '');

        $salesOrderDirects = $store
            ->salesOrderDirects()
            ->search($search)
            ->latest()
            ->paginate();

        return new SalesOrderDirectCollection($salesOrderDirects);
    }

    public function store(
        Request $request,
        Store $store
    ): SalesOrderDirectResource {
        $this->authorize('create', SalesOrderDirect::class);

        $validated = $request->validate([
            'order_by_id' => ['required', 'exists:users,id'],
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
            'submitted_by_id' => ['nullable', 'exists:users,id'],
            'received_by' => ['nullable', 'max:255', 'string'],
            'sign' => ['image', 'nullable'],
            'image_transfer' => ['image', 'nullable'],
            'image_receipt' => ['image', 'nullable'],
            'delivery_status' => ['required', 'max:255'],
            'shipping_cost' => ['nullable', 'max:255'],
        ]);

        if ($request->hasFile('sign')) {
            $validated['sign'] = $request->file('sign')->store('public');
        }

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

        $salesOrderDirect = $store->salesOrderDirects()->create($validated);

        return new SalesOrderDirectResource($salesOrderDirect);
    }
}
