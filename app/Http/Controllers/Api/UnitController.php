<?php

namespace App\Http\Controllers\Api;

use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\UnitResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\UnitCollection;
use App\Http\Requests\UnitStoreRequest;
use App\Http\Requests\UnitUpdateRequest;

class UnitController extends Controller
{
    public function index(Request $request): UnitCollection
    {
        $this->authorize('view-any', Unit::class);

        $search = $request->get('search', '');

        $units = Unit::search($search)
            ->latest()
            ->paginate();

        return new UnitCollection($units);
    }

    public function store(UnitStoreRequest $request): UnitResource
    {
        $this->authorize('create', Unit::class);

        $validated = $request->validated();

        $unit = Unit::create($validated);

        return new UnitResource($unit);
    }

    public function show(Request $request, Unit $unit): UnitResource
    {
        $this->authorize('view', $unit);

        return new UnitResource($unit);
    }

    public function update(UnitUpdateRequest $request, Unit $unit): UnitResource
    {
        $this->authorize('update', $unit);

        $validated = $request->validated();

        $unit->update($validated);

        return new UnitResource($unit);
    }

    public function destroy(Request $request, Unit $unit): Response
    {
        $this->authorize('delete', $unit);

        $unit->delete();

        return response()->noContent();
    }
}
