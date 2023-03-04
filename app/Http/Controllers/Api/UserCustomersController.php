<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerResource;
use App\Http\Resources\CustomerCollection;

class UserCustomersController extends Controller
{
    public function index(Request $request, User $user): CustomerCollection
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $customers = $user
            ->customers()
            ->search($search)
            ->latest()
            ->paginate();

        return new CustomerCollection($customers);
    }

    public function store(Request $request, User $user): CustomerResource
    {
        $this->authorize('create', Customer::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'no_telp' => [
                'nullable',
                'unique:customers,no_telp',
                'max:255',
                'string',
            ],
            'status' => ['required', 'in:1,2'],
        ]);

        $customer = $user->customers()->create($validated);

        return new CustomerResource($customer);
    }
}
