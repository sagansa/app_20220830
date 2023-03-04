<?php

namespace App\Http\Controllers\Api;

use App\Models\VehicleTax;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\VehicleTaxResource;
use App\Http\Resources\VehicleTaxCollection;
use App\Http\Requests\VehicleTaxStoreRequest;
use App\Http\Requests\VehicleTaxUpdateRequest;

class VehicleTaxController extends Controller
{
    public function index(Request $request): VehicleTaxCollection
    {
        $this->authorize('view-any', VehicleTax::class);

        $search = $request->get('search', '');

        $vehicleTaxes = VehicleTax::search($search)
            ->latest()
            ->paginate();

        return new VehicleTaxCollection($vehicleTaxes);
    }

    public function store(VehicleTaxStoreRequest $request): VehicleTaxResource
    {
        $this->authorize('create', VehicleTax::class);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $vehicleTax = VehicleTax::create($validated);

        return new VehicleTaxResource($vehicleTax);
    }

    public function show(
        Request $request,
        VehicleTax $vehicleTax
    ): VehicleTaxResource {
        $this->authorize('view', $vehicleTax);

        return new VehicleTaxResource($vehicleTax);
    }

    public function update(
        VehicleTaxUpdateRequest $request,
        VehicleTax $vehicleTax
    ): VehicleTaxResource {
        $this->authorize('update', $vehicleTax);

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($vehicleTax->image) {
                Storage::delete($vehicleTax->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        $vehicleTax->update($validated);

        return new VehicleTaxResource($vehicleTax);
    }

    public function destroy(Request $request, VehicleTax $vehicleTax): Response
    {
        $this->authorize('delete', $vehicleTax);

        if ($vehicleTax->image) {
            Storage::delete($vehicleTax->image);
        }

        $vehicleTax->delete();

        return response()->noContent();
    }
}
