<?php

namespace App\Http\Controllers\Api;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ContractEmployeeResource;
use App\Http\Resources\ContractEmployeeCollection;

class EmployeeContractEmployeesController extends Controller
{
    public function index(
        Request $request,
        Employee $employee
    ): ContractEmployeeCollection {
        $this->authorize('view', $employee);

        $search = $request->get('search', '');

        $contractEmployees = $employee
            ->contractEmployees()
            ->search($search)
            ->latest()
            ->paginate();

        return new ContractEmployeeCollection($contractEmployees);
    }

    public function store(
        Request $request,
        Employee $employee
    ): ContractEmployeeResource {
        $this->authorize('create', ContractEmployee::class);

        $validated = $request->validate([
            'file' => ['nullable', 'file'],
            'from_date' => ['required', 'date'],
            'until_date' => ['required', 'date'],
            'nominal_guarantee' => ['required', 'max:255'],
            'guarantee' => ['required', 'max:255'],
        ]);

        if ($request->hasFile('file')) {
            $validated['file'] = $request->file('file')->store('public');
        }

        $contractEmployee = $employee->contractEmployees()->create($validated);

        return new ContractEmployeeResource($contractEmployee);
    }
}
