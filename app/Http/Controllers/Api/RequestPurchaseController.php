<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\RequestPurchase;
use App\Http\Controllers\Controller;
use App\Http\Resources\RequestPurchaseResource;
use App\Http\Resources\RequestPurchaseCollection;
use App\Http\Requests\RequestPurchaseStoreRequest;
use App\Http\Requests\RequestPurchaseUpdateRequest;

class RequestPurchaseController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', RequestPurchase::class);

        $search = $request->get('search', '');

        $requestPurchases = RequestPurchase::search($search)
            ->latest()
            ->paginate();

        return new RequestPurchaseCollection($requestPurchases);
    }

    /**
     * @param \App\Http\Requests\RequestPurchaseStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequestPurchaseStoreRequest $request)
    {
        $this->authorize('create', RequestPurchase::class);

        $validated = $request->validated();

        $requestPurchase = RequestPurchase::create($validated);

        return new RequestPurchaseResource($requestPurchase);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\RequestPurchase $requestPurchase
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, RequestPurchase $requestPurchase)
    {
        $this->authorize('view', $requestPurchase);

        return new RequestPurchaseResource($requestPurchase);
    }

    /**
     * @param \App\Http\Requests\RequestPurchaseUpdateRequest $request
     * @param \App\Models\RequestPurchase $requestPurchase
     * @return \Illuminate\Http\Response
     */
    public function update(
        RequestPurchaseUpdateRequest $request,
        RequestPurchase $requestPurchase
    ) {
        $this->authorize('update', $requestPurchase);

        $validated = $request->validated();

        $requestPurchase->update($validated);

        return new RequestPurchaseResource($requestPurchase);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\RequestPurchase $requestPurchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, RequestPurchase $requestPurchase)
    {
        $this->authorize('delete', $requestPurchase);

        $requestPurchase->delete();

        return response()->noContent();
    }
}
