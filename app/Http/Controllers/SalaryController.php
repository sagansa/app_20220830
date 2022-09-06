<?php

namespace App\Http\Controllers;

use Image;
use App\Models\Salary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            ->paginate(10)
            ->withQueryString();

        return view('app.salaries.index', compact('salaries', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('app.salaries.create');
    }

    /**
     * @param \App\Http\Requests\SalaryStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SalaryStoreRequest $request)
    {
        $this->authorize('create', Salary::class);

        $validated = $request->validated();

        $validated['created_by_id'] = auth()->user()->id;
        $validated['status'] = '1';

        $salary = Salary::create($validated);

        return redirect()
            ->route('salaries.edit', $salary)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Salary $salary
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Salary $salary)
    {
        $this->authorize('view', $salary);

        return view('app.salaries.show', compact('salary'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Salary $salary
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Salary $salary)
    {
        $this->authorize('update', $salary);

        return view('app.salaries.edit', compact('salary'));
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

        if (
            auth()
                ->user()
                ->hasRole('supervisor|manager|super-admin')
        ) {
            $validated['approved_by_id'] = auth()->user()->id;
        }

        $salary->update($validated);

        return redirect()
            ->route('salaries.index')
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('salaries.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
