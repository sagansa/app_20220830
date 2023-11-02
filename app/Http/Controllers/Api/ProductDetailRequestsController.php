<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DetailRequestResource;
use App\Http\Resources\DetailRequestCollection;

class ProductDetailRequestsController extends Controller
{
    public function index(
        Request $request,
        Product $product
    ): DetailRequestCollection {
        $this->authorize('view', $product);

        $search = $request->get('search', '');

        $detailRequests = $product
            ->detailRequests()
            ->search($search)
            ->latest()
            ->paginate();

        return new DetailRequestCollection($detailRequests);
    }

    public function store(
        Request $request,
        Product $product
    ): DetailRequestResource {
        $this->authorize('create', DetailRequest::class);

        $validated = $request->validate([
            'quantity_plan' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:1,2,3,4,5'],
            'notes' => ['nullable', 'max:255', 'string'],
            'status' => ['required', 'max:255'],
        ]);

        $detailRequest = $product->detailRequests()->create($validated);

        return new DetailRequestResource($detailRequest);
    }
}
