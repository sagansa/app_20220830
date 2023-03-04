<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\MonthlySalary;
use App\Http\Controllers\Controller;
use App\Http\Resources\MonthlySalaryResource;
use App\Http\Resources\MonthlySalaryCollection;
use App\Http\Requests\MonthlySalaryStoreRequest;
use App\Http\Requests\MonthlySalaryUpdateRequest;

class MonthlySalaryController extends Controller
{
    public function index(Request $request): MonthlySalaryCollection
    {
        $this->authorize('view-any', MonthlySalary::class);

        $search = $request->get('search', '');

        $monthlySalaries = MonthlySalary::search($search)
            ->latest()
            ->paginate();

        return new MonthlySalaryCollection($monthlySalaries);
    }

    public function store(
        MonthlySalaryStoreRequest $request
    ): MonthlySalaryResource {
        $this->authorize('create', MonthlySalary::class);

        $validated = $request->validated();

        $monthlySalary = MonthlySalary::create($validated);

        return new MonthlySalaryResource($monthlySalary);
    }

    public function show(
        Request $request,
        MonthlySalary $monthlySalary
    ): MonthlySalaryResource {
        $this->authorize('view', $monthlySalary);

        return new MonthlySalaryResource($monthlySalary);
    }

    public function update(
        MonthlySalaryUpdateRequest $request,
        MonthlySalary $monthlySalary
    ): MonthlySalaryResource {
        $this->authorize('update', $monthlySalary);

        $validated = $request->validated();

        $monthlySalary->update($validated);

        return new MonthlySalaryResource($monthlySalary);
    }

    public function destroy(
        Request $request,
        MonthlySalary $monthlySalary
    ): Response {
        $this->authorize('delete', $monthlySalary);

        $monthlySalary->delete();

        return response()->noContent();
    }
}
