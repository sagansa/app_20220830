<?php

namespace App\Http\Controllers\Api;

use App\Models\DailySalary;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\DailySalaryResource;
use App\Http\Resources\DailySalaryCollection;
use App\Http\Requests\DailySalaryStoreRequest;
use App\Http\Requests\DailySalaryUpdateRequest;

class DailySalaryController extends Controller
{
    public function index(Request $request): DailySalaryCollection
    {
        $this->authorize('view-any', DailySalary::class);

        $search = $request->get('search', '');

        $dailySalaries = DailySalary::search($search)
            ->latest()
            ->paginate();

        return new DailySalaryCollection($dailySalaries);
    }

    public function store(DailySalaryStoreRequest $request): DailySalaryResource
    {
        $this->authorize('create', DailySalary::class);

        $validated = $request->validated();

        $dailySalary = DailySalary::create($validated);

        return new DailySalaryResource($dailySalary);
    }

    public function show(
        Request $request,
        DailySalary $dailySalary
    ): DailySalaryResource {
        $this->authorize('view', $dailySalary);

        return new DailySalaryResource($dailySalary);
    }

    public function update(
        DailySalaryUpdateRequest $request,
        DailySalary $dailySalary
    ): DailySalaryResource {
        $this->authorize('update', $dailySalary);

        $validated = $request->validated();

        $dailySalary->update($validated);

        return new DailySalaryResource($dailySalary);
    }

    public function destroy(
        Request $request,
        DailySalary $dailySalary
    ): Response {
        $this->authorize('delete', $dailySalary);

        $dailySalary->delete();

        return response()->noContent();
    }
}
