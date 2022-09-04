<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\PaymentReceipt;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\PaymentReceiptResource;
use App\Http\Resources\PaymentReceiptCollection;
use App\Http\Requests\PaymentReceiptStoreRequest;
use App\Http\Requests\PaymentReceiptUpdateRequest;

class PaymentReceiptController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', PaymentReceipt::class);

        $search = $request->get('search', '');

        $paymentReceipts = PaymentReceipt::search($search)
            ->latest()
            ->paginate();

        return new PaymentReceiptCollection($paymentReceipts);
    }

    /**
     * @param \App\Http\Requests\PaymentReceiptStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PaymentReceiptStoreRequest $request)
    {
        $this->authorize('create', PaymentReceipt::class);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $paymentReceipt = PaymentReceipt::create($validated);

        return new PaymentReceiptResource($paymentReceipt);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PaymentReceipt $paymentReceipt
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, PaymentReceipt $paymentReceipt)
    {
        $this->authorize('view', $paymentReceipt);

        return new PaymentReceiptResource($paymentReceipt);
    }

    /**
     * @param \App\Http\Requests\PaymentReceiptUpdateRequest $request
     * @param \App\Models\PaymentReceipt $paymentReceipt
     * @return \Illuminate\Http\Response
     */
    public function update(
        PaymentReceiptUpdateRequest $request,
        PaymentReceipt $paymentReceipt
    ) {
        $this->authorize('update', $paymentReceipt);

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($paymentReceipt->image) {
                Storage::delete($paymentReceipt->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        $paymentReceipt->update($validated);

        return new PaymentReceiptResource($paymentReceipt);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PaymentReceipt $paymentReceipt
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, PaymentReceipt $paymentReceipt)
    {
        $this->authorize('delete', $paymentReceipt);

        if ($paymentReceipt->image) {
            Storage::delete($paymentReceipt->image);
        }

        $paymentReceipt->delete();

        return response()->noContent();
    }
}
