<?php

namespace App\Http\Controllers\Api;

use App\Models\PaymentType;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentTypeResource;
use App\Http\Resources\PaymentTypeCollection;
use App\Http\Requests\PaymentTypeStoreRequest;
use App\Http\Requests\PaymentTypeUpdateRequest;

class PaymentTypeController extends Controller
{
    public function index(Request $request): PaymentTypeCollection
    {
        $this->authorize('view-any', PaymentType::class);

        $search = $request->get('search', '');

        $paymentTypes = PaymentType::search($search)
            ->latest()
            ->paginate();

        return new PaymentTypeCollection($paymentTypes);
    }

    public function store(PaymentTypeStoreRequest $request): PaymentTypeResource
    {
        $this->authorize('create', PaymentType::class);

        $validated = $request->validated();

        $paymentType = PaymentType::create($validated);

        return new PaymentTypeResource($paymentType);
    }

    public function show(
        Request $request,
        PaymentType $paymentType
    ): PaymentTypeResource {
        $this->authorize('view', $paymentType);

        return new PaymentTypeResource($paymentType);
    }

    public function update(
        PaymentTypeUpdateRequest $request,
        PaymentType $paymentType
    ): PaymentTypeResource {
        $this->authorize('update', $paymentType);

        $validated = $request->validated();

        $paymentType->update($validated);

        return new PaymentTypeResource($paymentType);
    }

    public function destroy(
        Request $request,
        PaymentType $paymentType
    ): Response {
        $this->authorize('delete', $paymentType);

        $paymentType->delete();

        return response()->noContent();
    }
}
