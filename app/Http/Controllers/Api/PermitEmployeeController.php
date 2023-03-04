<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\PermitEmployee;
use App\Http\Controllers\Controller;
use App\Http\Resources\PermitEmployeeResource;
use App\Http\Resources\PermitEmployeeCollection;
use App\Http\Requests\PermitEmployeeStoreRequest;
use App\Http\Requests\PermitEmployeeUpdateRequest;

class PermitEmployeeController extends Controller
{
    public function index(Request $request): PermitEmployeeCollection
    {
        $this->authorize('view-any', PermitEmployee::class);

        $search = $request->get('search', '');

        $permitEmployees = PermitEmployee::search($search)
            ->latest()
            ->paginate();

        return new PermitEmployeeCollection($permitEmployees);
    }

    public function store(
        PermitEmployeeStoreRequest $request
    ): PermitEmployeeResource {
        $this->authorize('create', PermitEmployee::class);

        $validated = $request->validated();

        $permitEmployee = PermitEmployee::create($validated);

        return new PermitEmployeeResource($permitEmployee);
    }

    public function show(
        Request $request,
        PermitEmployee $permitEmployee
    ): PermitEmployeeResource {
        $this->authorize('view', $permitEmployee);

        return new PermitEmployeeResource($permitEmployee);
    }

    public function update(
        PermitEmployeeUpdateRequest $request,
        PermitEmployee $permitEmployee
    ): PermitEmployeeResource {
        $this->authorize('update', $permitEmployee);

        $validated = $request->validated();

        $permitEmployee->update($validated);

        return new PermitEmployeeResource($permitEmployee);
    }

    public function destroy(
        Request $request,
        PermitEmployee $permitEmployee
    ): Response {
        $this->authorize('delete', $permitEmployee);

        $permitEmployee->delete();

        return response()->noContent();
    }
}
