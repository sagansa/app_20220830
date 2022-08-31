<?php

namespace App\Http\Controllers;

use Image;
use App\Models\Bank;
use App\Models\Regency;
use App\Models\Village;
use App\Models\Employee;
use App\Models\District;
use App\Models\Province;
use Illuminate\Http\Request;
use App\Models\EmployeeStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\EmployeeStoreRequest;
use App\Http\Requests\EmployeeUpdateRequest;

class EmployeeController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Employee::class);

        $search = $request->get('search', '');

        $employees = Employee::search($search)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('app.employees.index', compact('employees', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $districts = District::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $provinces = Province::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $regencies = Regency::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $villages = Village::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $banks = Bank::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $employeeStatuses = EmployeeStatus::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');

        return view(
            'app.employees.create',
            compact(
                'districts',
                'provinces',
                'regencies',
                'villages',
                'banks',
                'employeeStatuses'
            )
        );
    }

    /**
     * @param \App\Http\Requests\EmployeeStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeStoreRequest $request)
    {
        $this->authorize('create', Employee::class);

        $validated = $request->validated();

        if ($request->hasFile('image_identity_id')) {
            $file = $request->file('image_identity_id');
            $extension = $file->getClientOriginalExtension();
            $fileimage_identity_id = rand() . time() . '.' . $extension;
            $file->move('storage/', $fileimage_identity_id);
            Image::make('storage/' . $fileimage_identity_id)
                ->resize(400, 400, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save();

            $validated['image_identity_id'] = $fileimage_identity_id;
        }

        if ($request->hasFile('image_selfie')) {
            $file = $request->file('image_selfie');
            $extension = $file->getClientOriginalExtension();
            $fileimage_selfie = rand() . time() . '.' . $extension;
            $file->move('storage/', $fileimage_selfie);
            Image::make('storage/' . $fileimage_selfie)
                ->resize(400, 400, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save();

            $validated['image_selfie'] = $fileimage_selfie;
        }

        $validated['created_by_id'] = auth()->user()->id;
        $validated['status'] = '1';

        $employee = Employee::create($validated);

        return redirect()
            ->route('employees.edit', $employee)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Employee $employee)
    {
        $this->authorize('view', $employee);

        return view('app.employees.show', compact('employee'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Employee $employee)
    {
        $this->authorize('update', $employee);

        $districts = District::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $provinces = Province::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $regencies = Regency::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $villages = Village::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $banks = Bank::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $employeeStatuses = EmployeeStatus::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');

        return view(
            'app.employees.edit',
            compact(
                'employee',
                'districts',
                'provinces',
                'regencies',
                'villages',
                'banks',
                'employeeStatuses'
            )
        );
    }

    /**
     * @param \App\Http\Requests\EmployeeUpdateRequest $request
     * @param \App\Models\Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeeUpdateRequest $request, Employee $employee)
    {
        $this->authorize('update', $employee);

        $validated = $request->validated();
        if ($request->hasFile('image_identity_id')) {
            $file = $request->file('image_identity_id');
            $employee->delete_image_identity_id();
            $extension = $file->getClientOriginalExtension();
            $file_image_identity_id = rand() . time() . '.' . $extension;
            $file->move('storage/', $file_image_identity_id);
            Image::make('storage/' . $file_image_identity_id)
                ->resize(400, 400, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save();

            $validated['image_identity_id'] = $file_image_identity_id;
        }

        if ($request->hasFile('image_selfie')) {
            $file = $request->file('image_selfie');
            $employee->delete_image_selfie();
            $extension = $file->getClientOriginalExtension();
            $file_image_selfie = rand() . time() . '.' . $extension;
            $file->move('storage/', $file_image_selfie);
            Image::make('storage/' . $file_image_selfie)
                ->resize(400, 400, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save();

            $validated['image_selfie'] = $file_image_selfie;
        }

        if (
            auth()
                ->user()
                ->hasRole('supervisor|manager|super-admin')
        ) {
            $validated['approved_by_id'] = auth()->user()->id;
        }

        $employee->update($validated);

        return redirect()
            ->route('employees.index')
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Employee $employee)
    {
        $this->authorize('delete', $employee);

        if ($employee->image_identity_id) {
            Storage::delete($employee->image_identity_id);
        }

        if ($employee->image_selfie) {
            Storage::delete($employee->image_selfie);
        }

        $employee->delete();

        return redirect()
            ->route('employees.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
