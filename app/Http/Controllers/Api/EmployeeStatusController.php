<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\EmployeeStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\EmployeeStatusResource;
use App\Http\Resources\EmployeeStatusCollection;
use App\Http\Requests\EmployeeStatusStoreRequest;
use App\Http\Requests\EmployeeStatusUpdateRequest;

class EmployeeStatusController extends Controller
{
    public function index(Request $request): EmployeeStatusCollection
    {
        $this->authorize('view-any', EmployeeStatus::class);

        $search = $request->get('search', '');

        $employeeStatuses = EmployeeStatus::search($search)
            ->latest()
            ->paginate();

        return new EmployeeStatusCollection($employeeStatuses);
    }

    public function store(
        EmployeeStatusStoreRequest $request
    ): EmployeeStatusResource {
        $this->authorize('create', EmployeeStatus::class);

        $validated = $request->validated();

        $employeeStatus = EmployeeStatus::create($validated);

        return new EmployeeStatusResource($employeeStatus);
    }

    public function show(
        Request $request,
        EmployeeStatus $employeeStatus
    ): EmployeeStatusResource {
        $this->authorize('view', $employeeStatus);

        return new EmployeeStatusResource($employeeStatus);
    }

    public function update(
        EmployeeStatusUpdateRequest $request,
        EmployeeStatus $employeeStatus
    ): EmployeeStatusResource {
        $this->authorize('update', $employeeStatus);

        $validated = $request->validated();

        $employeeStatus->update($validated);

        return new EmployeeStatusResource($employeeStatus);
    }

    public function destroy(
        Request $request,
        EmployeeStatus $employeeStatus
    ): Response {
        $this->authorize('delete', $employeeStatus);

        $employeeStatus->delete();

        return response()->noContent();
    }
}
