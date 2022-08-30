<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\MonthlySalary;
use App\Http\Controllers\Controller;
use App\Http\Resources\MonthlySalaryResource;
use App\Http\Resources\MonthlySalaryCollection;
use App\Http\Requests\MonthlySalaryStoreRequest;
use App\Http\Requests\MonthlySalaryUpdateRequest;

class MonthlySalaryController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', MonthlySalary::class);

        $search = $request->get('search', '');

        $monthlySalaries = MonthlySalary::search($search)
            ->latest()
            ->paginate();

        return new MonthlySalaryCollection($monthlySalaries);
    }

    /**
     * @param \App\Http\Requests\MonthlySalaryStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(MonthlySalaryStoreRequest $request)
    {
        $this->authorize('create', MonthlySalary::class);

        $validated = $request->validated();

        $monthlySalary = MonthlySalary::create($validated);

        return new MonthlySalaryResource($monthlySalary);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\MonthlySalary $monthlySalary
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, MonthlySalary $monthlySalary)
    {
        $this->authorize('view', $monthlySalary);

        return new MonthlySalaryResource($monthlySalary);
    }

    /**
     * @param \App\Http\Requests\MonthlySalaryUpdateRequest $request
     * @param \App\Models\MonthlySalary $monthlySalary
     * @return \Illuminate\Http\Response
     */
    public function update(
        MonthlySalaryUpdateRequest $request,
        MonthlySalary $monthlySalary
    ) {
        $this->authorize('update', $monthlySalary);

        $validated = $request->validated();

        $monthlySalary->update($validated);

        return new MonthlySalaryResource($monthlySalary);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\MonthlySalary $monthlySalary
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, MonthlySalary $monthlySalary)
    {
        $this->authorize('delete', $monthlySalary);

        $monthlySalary->delete();

        return response()->noContent();
    }
}
