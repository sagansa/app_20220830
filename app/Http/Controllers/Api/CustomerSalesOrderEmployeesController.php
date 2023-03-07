<?php

namespace App\Http\Controllers\Api;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SalesOrderEmployeeResource;
use App\Http\Resources\SalesOrderEmployeeCollection;

class CustomerSalesOrderEmployeesController extends Controller
{
    public function index(
        Request $request,
        Customer $customer
    ): SalesOrderEmployeeCollection {
        $this->authorize('view', $customer);

        $search = $request->get('search', '');

        $salesOrderEmployees = $customer
            ->salesOrderEmployees()
            ->search($search)
            ->latest()
            ->paginate();

        return new SalesOrderEmployeeCollection($salesOrderEmployees);
    }

    public function store(
        Request $request,
        Customer $customer
    ): SalesOrderEmployeeResource {
        $this->authorize('create', SalesOrderEmployee::class);

        $validated = $request->validate([
            'store_id' => ['required', 'exists:stores,id'],
            'date' => ['required', 'date'],
            'image' => ['nullable', 'image'],
            'status' => ['required', 'in:1,2,3,4'],
            'notes' => ['nullable', 'max:255', 'string'],
            'user_id' => ['required', 'exists:users,id'],
            'delivery_address_id' => [
                'nullable',
                'exists:delivery_addresses,id',
            ],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $salesOrderEmployee = $customer
            ->salesOrderEmployees()
            ->create($validated);

        return new SalesOrderEmployeeResource($salesOrderEmployee);
    }
}
