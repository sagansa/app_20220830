<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\RequestPurchase;
use App\Http\Controllers\Controller;
use App\Http\Resources\RequestPurchaseResource;
use App\Http\Resources\RequestPurchaseCollection;
use App\Http\Requests\RequestPurchaseStoreRequest;
use App\Http\Requests\RequestPurchaseUpdateRequest;

class RequestPurchaseController extends Controller
{
    public function index(Request $request): RequestPurchaseCollection
    {
        $this->authorize('view-any', RequestPurchase::class);

        $search = $request->get('search', '');

        $requestPurchases = RequestPurchase::search($search)
            ->latest()
            ->paginate();

        return new RequestPurchaseCollection($requestPurchases);
    }

    public function store(
        RequestPurchaseStoreRequest $request
    ): RequestPurchaseResource {
        $this->authorize('create', RequestPurchase::class);

        $validated = $request->validated();

        $requestPurchase = RequestPurchase::create($validated);

        return new RequestPurchaseResource($requestPurchase);
    }

    public function show(
        Request $request,
        RequestPurchase $requestPurchase
    ): RequestPurchaseResource {
        $this->authorize('view', $requestPurchase);

        return new RequestPurchaseResource($requestPurchase);
    }

    public function update(
        RequestPurchaseUpdateRequest $request,
        RequestPurchase $requestPurchase
    ): RequestPurchaseResource {
        $this->authorize('update', $requestPurchase);

        $validated = $request->validated();

        $requestPurchase->update($validated);

        return new RequestPurchaseResource($requestPurchase);
    }

    public function destroy(
        Request $request,
        RequestPurchase $requestPurchase
    ): Response {
        $this->authorize('delete', $requestPurchase);

        $requestPurchase->delete();

        return response()->noContent();
    }
}
