<?php

namespace App\Http\Controllers;

use Image;
use Illuminate\Http\Request;
use App\Models\PaymentReceipt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
            ->paginate(10)
            ->withQueryString();

        if (Auth::user()->hasRole('staff|supervisor')) {
            $paymentReceipts->whereNotIn('payment_for', ['2']);
        }

        return view(
            'app.payment_receipts.index',
            compact('paymentReceipts', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('app.payment_receipts.create');
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
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $fileimage = rand() . time() . '.' . $extension;
            $file->move('storage/', $fileimage);
            Image::make('storage/' . $fileimage)
                ->resize(600, 600, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save();

            $validated['image'] = $fileimage;
        }

        if ($request->hasFile('image_adjust')) {
            $file = $request->file('image_adjust');
            $extension = $file->getClientOriginalExtension();
            $fileimage_adjust = rand() . time() . '.' . $extension;
            $file->move('storage/', $fileimage_adjust);
            Image::make('storage/' . $fileimage_adjust)
                ->resize(400, 400, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save();

            $validated['image_adjust'] = $fileimage_adjust;
        }

        $validated['amount'] = 0;

        $paymentReceipt = PaymentReceipt::create($validated);

        return redirect()
            ->route('payment-receipts.show', $paymentReceipt)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PaymentReceipt $paymentReceipt
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, PaymentReceipt $paymentReceipt)
    {
        $this->authorize('view', $paymentReceipt);

        return view('app.payment_receipts.show', compact('paymentReceipt'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PaymentReceipt $paymentReceipt
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, PaymentReceipt $paymentReceipt)
    {
        $this->authorize('update', $paymentReceipt);

        return view('app.payment_receipts.edit', compact('paymentReceipt'));
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
            $file = $request->file('image');
            $paymentReceipt->delete_image();
            $extension = $file->getClientOriginalExtension();
            $file_image = rand() . time() . '.' . $extension;
            $file->move('storage/', $file_image);
            Image::make('storage/' . $file_image)
                ->resize(600, 600, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save();

            $validated['image'] = $file_image;
        }

        if ($request->hasFile('image_adjust')) {
            $file = $request->file('image_adjust');
            $paymentReceipt->delete_image_adjust();
            $extension = $file->getClientOriginalExtension();
            $file_image_adjust = rand() . time() . '.' . $extension;
            $file->move('storage/', $file_image_adjust);
            Image::make('storage/' . $file_image_adjust)
                ->resize(400, 400, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save();

            $validated['image_adjust'] = $file_image_adjust;
        }

        if (
            auth()
                ->user()
                ->hasRole('supervisor|manager|super-admin')
        ) {
            $validated['approved_by_id'] = auth()->user()->id;
        }

        $paymentReceipt->update($validated);

        return redirect()
            ->route('payment-receipts.show', $paymentReceipt)
            ->withSuccess(__('crud.common.saved'));
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

        if ($paymentReceipt->image_adjust) {
            Storage::delete($paymentReceipt->image_adjust);
        }

        $paymentReceipt->delete();

        return redirect()
            ->route('payment-receipts.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
