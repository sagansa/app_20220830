<?php

namespace App\Http\Controllers\Api;

use App\Models\UtilityUsage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\UtilityUsageResource;
use App\Http\Resources\UtilityUsageCollection;
use App\Http\Requests\UtilityUsageStoreRequest;
use App\Http\Requests\UtilityUsageUpdateRequest;

class UtilityUsageController extends Controller
{
    public function index(Request $request): UtilityUsageCollection
    {
        $this->authorize('view-any', UtilityUsage::class);

        $search = $request->get('search', '');

        $utilityUsages = UtilityUsage::search($search)
            ->latest()
            ->paginate();

        return new UtilityUsageCollection($utilityUsages);
    }

    public function store(
        UtilityUsageStoreRequest $request
    ): UtilityUsageResource {
        $this->authorize('create', UtilityUsage::class);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $utilityUsage = UtilityUsage::create($validated);

        return new UtilityUsageResource($utilityUsage);
    }

    public function show(
        Request $request,
        UtilityUsage $utilityUsage
    ): UtilityUsageResource {
        $this->authorize('view', $utilityUsage);

        return new UtilityUsageResource($utilityUsage);
    }

    public function update(
        UtilityUsageUpdateRequest $request,
        UtilityUsage $utilityUsage
    ): UtilityUsageResource {
        $this->authorize('update', $utilityUsage);

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($utilityUsage->image) {
                Storage::delete($utilityUsage->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        $utilityUsage->update($validated);

        return new UtilityUsageResource($utilityUsage);
    }

    public function destroy(
        Request $request,
        UtilityUsage $utilityUsage
    ): Response {
        $this->authorize('delete', $utilityUsage);

        if ($utilityUsage->image) {
            Storage::delete($utilityUsage->image);
        }

        $utilityUsage->delete();

        return response()->noContent();
    }
}
