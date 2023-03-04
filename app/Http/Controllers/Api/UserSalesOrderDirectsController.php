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
            ->salesOrderDirects2()
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
            'transfer_to_account_id' => [
                'required',
                'exists:transfer_to_accounts,id',
            ],
            'payment_status' => ['required', 'max:255'],
            'store_id' => ['nullable', 'exists:stores,id'],
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

        $salesOrderDirect = $user->salesOrderDirects2()->create($validated);

        return new SalesOrderDirectResource($salesOrderDirect);
    }
}
