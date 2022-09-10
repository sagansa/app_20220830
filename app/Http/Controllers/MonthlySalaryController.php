<?php

namespace App\Http\Controllers;

use Image;
use Illuminate\Http\Request;
use App\Models\MonthlySalary;
use Illuminate\Support\Facades\Auth;
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
            ->paginate(10)
            ->withQueryString();

        return view(
            'app.monthly_salaries.index',
            compact('monthlySalaries', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('app.monthly_salaries.create');
    }

    /**
     * @param \App\Http\Requests\MonthlySalaryStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(MonthlySalaryStoreRequest $request)
    {
        $this->authorize('create', MonthlySalary::class);

        $validated = $request->validated();

        $validated['created_by_id'] = auth()->user()->id;
        $validated['status'] = '1';

        $monthlySalary = MonthlySalary::create($validated);

        return redirect()
            ->route('monthly-salaries.edit', $monthlySalary)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\MonthlySalary $monthlySalary
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, MonthlySalary $monthlySalary)
    {
        $this->authorize('view', $monthlySalary);

        return view('app.monthly_salaries.show', compact('monthlySalary'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\MonthlySalary $monthlySalary
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, MonthlySalary $monthlySalary)
    {
        $this->authorize('update', $monthlySalary);

        return view('app.monthly_salaries.edit', compact('monthlySalary'));
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

        if (
            auth()
                ->user()
                ->hasRole('supervisor|manager|super-admin')
        ) {
            $validated['approved_by_id'] = auth()->user()->id;
        }

        $monthlySalary->update($validated);

        return redirect()
            ->route('monthly-salaries.index')
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('monthly-salaries.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
