<?php

namespace App\Http\Controllers\Api;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SalesOrderEmployeeResource;
use App\Http\Resources\SalesOrderEmployeeCollection;

class StoreSalesOrderEmployeesController extends Controller
{
    public function index(
        Request $request,
        Store $store
    ): SalesOrderEmployeeCollection {
        $this->authorize('view', $store);

        $search = $request->get('search', '');

        $salesOrderEmployees = $store
            ->salesOrderEmployees()
            ->search($search)
            ->latest()
            ->paginate();

        return new SalesOrderEmployeeCollection($salesOrderEmployees);
    }

    public function store(
        Request $request,
        Store $store
    ): SalesOrderEmployeeResource {
        $this->authorize('create', SalesOrderEmployee::class);

        $validated = $request->validate([
            'customer' => ['required', 'max:255', 'string'],
            'detail_customer' => ['required', 'max:255', 'string'],
            'date' => ['required', 'date'],
            'image' => ['nullable', 'image'],
            'status' => ['nullable', 'max:255'],
            'user_id' => ['nullable', 'exists:users,id'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $salesOrderEmployee = $store->salesOrderEmployees()->create($validated);

        return new SalesOrderEmployeeResource($salesOrderEmployee);
    }
}
