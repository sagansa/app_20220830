<?php

namespace App\Http\Controllers\Api;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\EmployeeCollection;
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
            ->paginate();

        return new EmployeeCollection($employees);
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
            $validated['image_identity_id'] = $request
                ->file('image_identity_id')
                ->store('public');
        }

        if ($request->hasFile('image_selfie')) {
            $validated['image_selfie'] = $request
                ->file('image_selfie')
                ->store('public');
        }

        $employee = Employee::create($validated);

        return new EmployeeResource($employee);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Employee $employee)
    {
        $this->authorize('view', $employee);

        return new EmployeeResource($employee);
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
            if ($employee->image_identity_id) {
                Storage::delete($employee->image_identity_id);
            }

            $validated['image_identity_id'] = $request
                ->file('image_identity_id')
                ->store('public');
        }

        if ($request->hasFile('image_selfie')) {
            if ($employee->image_selfie) {
                Storage::delete($employee->image_selfie);
            }

            $validated['image_selfie'] = $request
                ->file('image_selfie')
                ->store('public');
        }

        $employee->update($validated);

        return new EmployeeResource($employee);
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

        return response()->noContent();
    }
}
