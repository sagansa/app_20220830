<?php

namespace App\Http\Controllers\Api;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SavingResource;
use App\Http\Resources\SavingCollection;

class EmployeeSavingsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Employee $employee)
    {
        $this->authorize('view', $employee);

        $search = $request->get('search', '');

        $savings = $employee
            ->savings()
            ->search($search)
            ->latest()
            ->paginate();

        return new SavingCollection($savings);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Employee $employee)
    {
        $this->authorize('create', Saving::class);

        $validated = $request->validate([
            'debet_credit' => ['required', 'max:255'],
            'nominal' => ['required', 'numeric', 'min:0'],
        ]);

        $saving = $employee->savings()->create($validated);

        return new SavingResource($saving);
    }
}
