<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PermitEmployeeResource;
use App\Http\Resources\PermitEmployeeCollection;

class UserPermitEmployeesController extends Controller
{
    public function index(
        Request $request,
        User $user
    ): PermitEmployeeCollection {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $permitEmployees = $user
            ->permitEmployeesApproved()
            ->search($search)
            ->latest()
            ->paginate();

        return new PermitEmployeeCollection($permitEmployees);
    }

    public function store(Request $request, User $user): PermitEmployeeResource
    {
        $this->authorize('create', PermitEmployee::class);

        $validated = $request->validate([
            'reason' => ['required', 'max:255'],
            'from_date' => ['required', 'date'],
            'until_date' => ['required', 'date'],
            'notes' => ['nullable', 'string'],
            'status' => ['required', 'max:255'],
        ]);

        $permitEmployee = $user->permitEmployeesApproved()->create($validated);

        return new PermitEmployeeResource($permitEmployee);
    }
}
