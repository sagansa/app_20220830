<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\PaymentReceipt;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\PaymentReceiptResource;
use App\Http\Resources\PaymentReceiptCollection;
use App\Http\Requests\PaymentReceiptStoreRequest;
use App\Http\Requests\PaymentReceiptUpdateRequest;

class PaymentReceiptController extends Controller
{
    public function index(Request $request): PaymentReceiptCollection
    {
        $this->authorize('view-any', PaymentReceipt::class);

        $search = $request->get('search', '');

        $paymentReceipts = PaymentReceipt::search($search)
            ->latest()
            ->paginate();

        return new PaymentReceiptCollection($paymentReceipts);
    }

    public function store(
        PaymentReceiptStoreRequest $request
    ): PaymentReceiptResource {
        $this->authorize('create', PaymentReceipt::class);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        if ($request->hasFile('image_adjust')) {
            $validated['image_adjust'] = $request
                ->file('image_adjust')
                ->store('public');
        }

        $paymentReceipt = PaymentReceipt::create($validated);

        return new PaymentReceiptResource($paymentReceipt);
    }

    public function show(
        Request $request,
        PaymentReceipt $paymentReceipt
    ): PaymentReceiptResource {
        $this->authorize('view', $paymentReceipt);

        return new PaymentReceiptResource($paymentReceipt);
    }

    public function update(
        PaymentReceiptUpdateRequest $request,
        PaymentReceipt $paymentReceipt
    ): PaymentReceiptResource {
        $this->authorize('update', $paymentReceipt);

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($paymentReceipt->image) {
                Storage::delete($paymentReceipt->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        if ($request->hasFile('image_adjust')) {
            if ($paymentReceipt->image_adjust) {
                Storage::delete($paymentReceipt->image_adjust);
            }

            $validated['image_adjust'] = $request
                ->file('image_adjust')
                ->store('public');
        }

        $paymentReceipt->update($validated);

        return new PaymentReceiptResource($paymentReceipt);
    }

    public function destroy(
        Request $request,
        PaymentReceipt $paymentReceipt
    ): Response {
        $this->authorize('delete', $paymentReceipt);

        if ($paymentReceipt->image) {
            Storage::delete($paymentReceipt->image);
        }

        if ($paymentReceipt->image_adjust) {
            Storage::delete($paymentReceipt->image_adjust);
        }

        $paymentReceipt->delete();

        return response()->noContent();
    }
}
