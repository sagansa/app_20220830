<?php

namespace App\Http\Controllers\Api;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DetailRequestResource;
use App\Http\Resources\DetailRequestCollection;

class StoreDetailRequestsController extends Controller
{
    public function index(
        Request $request,
        Store $store
    ): DetailRequestCollection {
        $this->authorize('view', $store);

        $search = $request->get('search', '');

        $detailRequests = $store
            ->detailRequests()
            ->search($search)
            ->latest()
            ->paginate();

        return new DetailRequestCollection($detailRequests);
    }

    public function store(Request $request, Store $store): DetailRequestResource
    {
        $this->authorize('create', DetailRequest::class);

        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity_plan' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:1,2,3,4,5'],
            'notes' => ['nullable', 'max:255', 'string'],
            'status' => ['required', 'max:255'],
        ]);

        $detailRequest = $store->detailRequests()->create($validated);

        return new DetailRequestResource($detailRequest);
    }
}
