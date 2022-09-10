<?php

namespace App\Http\Controllers\Api;

use App\Models\DailySalary;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DailySalaryResource;
use App\Http\Resources\DailySalaryCollection;
use App\Http\Requests\DailySalaryStoreRequest;
use App\Http\Requests\DailySalaryUpdateRequest;

class DailySalaryController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', DailySalary::class);

        $search = $request->get('search', '');

        $dailySalaries = DailySalary::search($search)
            ->latest()
            ->paginate();

        return new DailySalaryCollection($dailySalaries);
    }

    /**
     * @param \App\Http\Requests\DailySalaryStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(DailySalaryStoreRequest $request)
    {
        $this->authorize('create', DailySalary::class);

        $validated = $request->validated();

        $dailySalary = DailySalary::create($validated);

        return new DailySalaryResource($dailySalary);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DailySalary $dailySalary
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, DailySalary $dailySalary)
    {
        $this->authorize('view', $dailySalary);

        return new DailySalaryResource($dailySalary);
    }

    /**
     * @param \App\Http\Requests\DailySalaryUpdateRequest $request
     * @param \App\Models\DailySalary $dailySalary
     * @return \Illuminate\Http\Response
     */
    public function update(
        DailySalaryUpdateRequest $request,
        DailySalary $dailySalary
    ) {
        $this->authorize('update', $dailySalary);

        $validated = $request->validated();

        $dailySalary->update($validated);

        return new DailySalaryResource($dailySalary);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DailySalary $dailySalary
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, DailySalary $dailySalary)
    {
        $this->authorize('delete', $dailySalary);

        $dailySalary->delete();

        return response()->noContent();
    }
}
