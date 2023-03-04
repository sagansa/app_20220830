<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SalesOrderEmployeeResource;
use App\Http\Resources\SalesOrderEmployeeCollection;

class UserSalesOrderEmployeesController extends Controller
{
    public function index(
        Request $request,
        User $user
    ): SalesOrderEmployeeCollection {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $salesOrderEmployees = $user
            ->salesOrderEmployees()
            ->search($search)
            ->latest()
            ->paginate();

        return new SalesOrderEmployeeCollection($salesOrderEmployees);
    }

    public function store(
        Request $request,
        User $user
    ): SalesOrderEmployeeResource {
        $this->authorize('create', SalesOrderEmployee::class);

        $validated = $request->validate([
            'store_id' => ['required', 'exists:stores,id'],
            'customer_id' => ['required', 'exists:customers,id'],
            'delivery_address_id' => [
                'nullable',
                'exists:delivery_addresses,id',
            ],
            'date' => ['required', 'date'],
            'image' => ['nullable', 'image'],
            'status' => ['required', 'in:1,2,3,4'],
            'notes' => ['nullable', 'max:255', 'string'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $salesOrderEmployee = $user->salesOrderEmployees()->create($validated);

        return new SalesOrderEmployeeResource($salesOrderEmployee);
    }
}
