<?php

namespace App\Http\Controllers\Api;

use App\Models\PaymentType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DetailRequestResource;
use App\Http\Resources\DetailRequestCollection;

class PaymentTypeDetailRequestsController extends Controller
{
    public function index(
        Request $request,
        PaymentType $paymentType
    ): DetailRequestCollection {
        $this->authorize('view', $paymentType);

        $search = $request->get('search', '');

        $detailRequests = $paymentType
            ->detailRequests()
            ->search($search)
            ->latest()
            ->paginate();

        return new DetailRequestCollection($detailRequests);
    }

    public function store(
        Request $request,
        PaymentType $paymentType
    ): DetailRequestResource {
        $this->authorize('create', DetailRequest::class);

        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity_plan' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:1,2,3,4,5'],
            'notes' => ['nullable', 'max:255', 'string'],
            'status' => ['required', 'max:255'],
        ]);

        $detailRequest = $paymentType->detailRequests()->create($validated);

        return new DetailRequestResource($detailRequest);
    }
}
