<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\VehicleCertificate;
use App\Http\Controllers\Controller;
use App\Http\Resources\VehicleCertificateResource;
use App\Http\Resources\VehicleCertificateCollection;
use App\Http\Requests\VehicleCertificateStoreRequest;
use App\Http\Requests\VehicleCertificateUpdateRequest;

class VehicleCertificateController extends Controller
{
    public function index(Request $request): VehicleCertificateCollection
    {
        $this->authorize('view-any', VehicleCertificate::class);

        $search = $request->get('search', '');

        $vehicleCertificates = VehicleCertificate::search($search)
            ->latest()
            ->paginate();

        return new VehicleCertificateCollection($vehicleCertificates);
    }

    public function store(
        VehicleCertificateStoreRequest $request
    ): VehicleCertificateResource {
        $this->authorize('create', VehicleCertificate::class);

        $validated = $request->validated();

        $vehicleCertificate = VehicleCertificate::create($validated);

        return new VehicleCertificateResource($vehicleCertificate);
    }

    public function show(
        Request $request,
        VehicleCertificate $vehicleCertificate
    ): VehicleCertificateResource {
        $this->authorize('view', $vehicleCertificate);

        return new VehicleCertificateResource($vehicleCertificate);
    }

    public function update(
        VehicleCertificateUpdateRequest $request,
        VehicleCertificate $vehicleCertificate
    ): VehicleCertificateResource {
        $this->authorize('update', $vehicleCertificate);

        $validated = $request->validated();

        $vehicleCertificate->update($validated);

        return new VehicleCertificateResource($vehicleCertificate);
    }

    public function destroy(
        Request $request,
        VehicleCertificate $vehicleCertificate
    ): Response {
        $this->authorize('delete', $vehicleCertificate);

        $vehicleCertificate->delete();

        return response()->noContent();
    }
}
