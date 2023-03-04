<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\AdminCashless;
use App\Http\Controllers\Controller;
use App\Http\Resources\AdminCashlessResource;
use App\Http\Resources\AdminCashlessCollection;
use App\Http\Requests\AdminCashlessStoreRequest;
use App\Http\Requests\AdminCashlessUpdateRequest;

class AdminCashlessController extends Controller
{
    public function index(Request $request): AdminCashlessCollection
    {
        $this->authorize('view-any', AdminCashless::class);

        $search = $request->get('search', '');

        $adminCashlesses = AdminCashless::search($search)
            ->latest()
            ->paginate();

        return new AdminCashlessCollection($adminCashlesses);
    }

    public function store(
        AdminCashlessStoreRequest $request
    ): AdminCashlessResource {
        $this->authorize('create', AdminCashless::class);

        $validated = $request->validated();

        $adminCashless = AdminCashless::create($validated);

        return new AdminCashlessResource($adminCashless);
    }

    public function show(
        Request $request,
        AdminCashless $adminCashless
    ): AdminCashlessResource {
        $this->authorize('view', $adminCashless);

        return new AdminCashlessResource($adminCashless);
    }

    public function update(
        AdminCashlessUpdateRequest $request,
        AdminCashless $adminCashless
    ): AdminCashlessResource {
        $this->authorize('update', $adminCashless);

        $validated = $request->validated();

        $adminCashless->update($validated);

        return new AdminCashlessResource($adminCashless);
    }

    public function destroy(
        Request $request,
        AdminCashless $adminCashless
    ): Response {
        $this->authorize('delete', $adminCashless);

        $adminCashless->delete();

        return response()->noContent();
    }
}
