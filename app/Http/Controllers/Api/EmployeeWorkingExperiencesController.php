<?php

namespace App\Http\Controllers\Api;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\WorkingExperienceResource;
use App\Http\Resources\WorkingExperienceCollection;

class EmployeeWorkingExperiencesController extends Controller
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

        $workingExperiences = $employee
            ->workingExperiences()
            ->search($search)
            ->latest()
            ->paginate();

        return new WorkingExperienceCollection($workingExperiences);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Employee $employee)
    {
        $this->authorize('create', WorkingExperience::class);

        $validated = $request->validate([
            'place' => ['required', 'max:255', 'string'],
            'position' => ['required', 'max:255', 'string'],
            'salary_per_month' => ['required', 'min:0', 'integer'],
            'previous_boss_name' => ['nullable', 'max:255', 'string'],
            'previous_boss_no' => [
                'nullable',
                'numeric',
                'digits_between:8,16',
                'min:0',
            ],
            'from_date' => ['required', 'date'],
            'until_date' => ['required', 'date'],
            'reason' => ['required', 'string'],
        ]);

        $workingExperience = $employee
            ->workingExperiences()
            ->create($validated);

        return new WorkingExperienceResource($workingExperience);
    }
}
