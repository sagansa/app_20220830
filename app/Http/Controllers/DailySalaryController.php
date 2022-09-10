<?php

namespace App\Http\Controllers;

use Image;
use App\Models\Store;
use App\Models\Presence;
use App\Models\ShiftStore;
use App\Models\DailySalary;
use App\Models\PaymentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            ->paginate(10)
            ->withQueryString();

        return view(
            'app.daily_salaries.index',
            compact('dailySalaries', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $stores = Store::orderBy('name', 'asc')
            ->whereNotIn('status', ['8'])
            ->pluck('name', 'id');
        $shiftStores = ShiftStore::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $paymentTypes = PaymentType::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $presences = Presence::orderBy('image_in', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('image_in', 'id');

        return view(
            'app.daily_salaries.create',
            compact('stores', 'shiftStores', 'paymentTypes', 'presences')
        );
    }

    /**
     * @param \App\Http\Requests\DailySalaryStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(DailySalaryStoreRequest $request)
    {
        $this->authorize('create', DailySalary::class);

        $validated = $request->validated();

        $validated['created_by_id'] = auth()->user()->id;
        $validated['status'] = '1';

        $dailySalary = DailySalary::create($validated);

        return redirect()
            ->route('daily-salaries.edit', $dailySalary)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DailySalary $dailySalary
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, DailySalary $dailySalary)
    {
        $this->authorize('view', $dailySalary);

        return view('app.daily_salaries.show', compact('dailySalary'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DailySalary $dailySalary
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, DailySalary $dailySalary)
    {
        $this->authorize('update', $dailySalary);

        $stores = Store::orderBy('name', 'asc')
            ->whereNotIn('status', ['8'])
            ->pluck('name', 'id');
        $shiftStores = ShiftStore::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $paymentTypes = PaymentType::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $presences = Presence::orderBy('image_in', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('image_in', 'id');

        return view(
            'app.daily_salaries.edit',
            compact(
                'dailySalary',
                'stores',
                'shiftStores',
                'paymentTypes',
                'presences'
            )
        );
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

        if (
            auth()
                ->user()
                ->hasRole('supervisor|manager|super-admin')
        ) {
            $validated['approved_by_id'] = auth()->user()->id;
        }

        $dailySalary->update($validated);

        return redirect()
            ->route('daily-salaries.index')
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('daily-salaries.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
