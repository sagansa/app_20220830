<?php

namespace App\Http\Controllers\Api;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SalesOrderEmployeeResource;
use App\Http\Resources\SalesOrderEmployeeCollection;

class StoreSalesOrderEmployeesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Store $store
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Store $store)
    {
        $this->authorize('view', $store);

        $search = $request->get('search', '');

        $salesOrderEmployees = $store
            ->salesOrderEmployees()
            ->search($search)
            ->latest()
            ->paginate();

        return new SalesOrderEmployeeCollection($salesOrderEmployees);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Store $store
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Store $store)
    {
        $this->authorize('create', SalesOrderEmployee::class);

        $validated = $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'delivery_address_id' => [
                'nullable',
                'exists:delivery_addresses,id',
            ],
            'date' => ['required', 'date'],
            'image' => ['nullable', 'image'],
            'status' => ['required', 'in:1,2,3,4'],
            'notes' => ['nullable', 'max:255', 'string'],
            'user_id' => ['required', 'exists:users,id'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $salesOrderEmployee = $store->salesOrderEmployees()->create($validated);

        return new SalesOrderEmployeeResource($salesOrderEmployee);
    }
}
