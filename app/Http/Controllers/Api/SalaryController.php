<?php

namespace App\Http\Controllers\Api;

use App\Models\Salary;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SalaryResource;
use App\Http\Resources\SalaryCollection;
use App\Http\Requests\SalaryStoreRequest;
use App\Http\Requests\SalaryUpdateRequest;

class SalaryController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Salary::class);

        $search = $request->get('search', '');

        $salaries = Salary::search($search)
            ->latest()
            ->paginate();

        return new SalaryCollection($salaries);
    }

    /**
     * @param \App\Http\Requests\SalaryStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SalaryStoreRequest $request)
    {
        $this->authorize('create', Salary::class);

        $validated = $request->validated();

        $salary = Salary::create($validated);

        return new SalaryResource($salary);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Salary $salary
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Salary $salary)
    {
        $this->authorize('view', $salary);

        return new SalaryResource($salary);
    }

    /**
     * @param \App\Http\Requests\SalaryUpdateRequest $request
     * @param \App\Models\Salary $salary
     * @return \Illuminate\Http\Response
     */
    public function update(SalaryUpdateRequest $request, Salary $salary)
    {
        $this->authorize('update', $salary);

        $validated = $request->validated();

        $salary->update($validated);

        return new SalaryResource($salary);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Salary $salary
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Salary $salary)
    {
        $this->authorize('delete', $salary);

        $salary->delete();

        return response()->noContent();
    }
}
