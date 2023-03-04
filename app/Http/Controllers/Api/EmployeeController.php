<?php

namespace App\Http\Controllers\Api;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\EmployeeCollection;
use App\Http\Requests\EmployeeStoreRequest;
use App\Http\Requests\EmployeeUpdateRequest;

class EmployeeController extends Controller
{
    public function index(Request $request): EmployeeCollection
    {
        $this->authorize('view-any', Employee::class);

        $search = $request->get('search', '');

        $employees = Employee::search($search)
            ->latest()
            ->paginate();

        return new EmployeeCollection($employees);
    }

    public function store(EmployeeStoreRequest $request): EmployeeResource
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

    public function show(Request $request, Employee $employee): EmployeeResource
    {
        $this->authorize('view', $employee);

        return new EmployeeResource($employee);
    }

    public function update(
        EmployeeUpdateRequest $request,
        Employee $employee
    ): EmployeeResource {
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

    public function destroy(Request $request, Employee $employee): Response
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
