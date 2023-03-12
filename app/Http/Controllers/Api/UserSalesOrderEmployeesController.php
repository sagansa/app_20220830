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
            'customer' => ['required', 'max:255', 'string'],
            'detail_customer' => ['required', 'max:255', 'string'],
            'date' => ['required', 'date'],
            'image' => ['nullable', 'image'],
            'status' => ['nullable', 'max:255'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $salesOrderEmployee = $user->salesOrderEmployees()->create($validated);

        return new SalesOrderEmployeeResource($salesOrderEmployee);
    }
}
