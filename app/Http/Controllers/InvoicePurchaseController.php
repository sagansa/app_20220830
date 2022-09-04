<?php

namespace App\Http\Controllers;

use Image;
use App\Models\User;
use App\Models\Store;
use App\Models\Supplier;
use App\Models\PaymentType;
use Illuminate\Http\Request;
use App\Models\InvoicePurchase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\InvoicePurchaseStoreRequest;
use App\Http\Requests\InvoicePurchaseUpdateRequest;

class InvoicePurchaseController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', InvoicePurchase::class);

        $search = $request->get('search', '');

        $invoicePurchases = InvoicePurchase::search($search)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'app.invoice_purchases.index',
            compact('invoicePurchases', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $paymentTypes = PaymentType::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $stores = Store::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $suppliers = Supplier::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $users = User::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');

        return view(
            'app.invoice_purchases.create',
            compact('paymentTypes', 'stores', 'suppliers', 'users', 'users')
        );
    }

    /**
     * @param \App\Http\Requests\InvoicePurchaseStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(InvoicePurchaseStoreRequest $request)
    {
        $this->authorize('create', InvoicePurchase::class);

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $fileimage = rand() . time() . '.' . $extension;
            $file->move('storage/', $fileimage);
            Image::make('storage/' . $fileimage)
                ->resize(400, 400, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save();

            $validated['image'] = $fileimage;
        }

        $validated['created_by_id'] = auth()->user()->id;
        $validated['status'] = '1';

        $invoicePurchase = InvoicePurchase::create($validated);

        return redirect()
            ->route('invoice-purchases.edit', $invoicePurchase)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\InvoicePurchase $invoicePurchase
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, InvoicePurchase $invoicePurchase)
    {
        $this->authorize('view', $invoicePurchase);

        return view('app.invoice_purchases.show', compact('invoicePurchase'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\InvoicePurchase $invoicePurchase
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, InvoicePurchase $invoicePurchase)
    {
        $this->authorize('update', $invoicePurchase);

        $paymentTypes = PaymentType::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $stores = Store::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $suppliers = Supplier::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $users = User::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');

        return view(
            'app.invoice_purchases.edit',
            compact(
                'invoicePurchase',
                'paymentTypes',
                'stores',
                'suppliers',
                'users',
                'users'
            )
        );
    }

    /**
     * @param \App\Http\Requests\InvoicePurchaseUpdateRequest $request
     * @param \App\Models\InvoicePurchase $invoicePurchase
     * @return \Illuminate\Http\Response
     */
    public function update(
        InvoicePurchaseUpdateRequest $request,
        InvoicePurchase $invoicePurchase
    ) {
        $this->authorize('update', $invoicePurchase);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $invoicePurchase->delete_image();
            $extension = $file->getClientOriginalExtension();
            $file_image = rand() . time() . '.' . $extension;
            $file->move('storage/', $file_image);
            Image::make('storage/' . $file_image)
                ->resize(400, 400, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save();

            $validated['image'] = $file_image;
        }

        if (
            auth()
                ->user()
                ->hasRole('supervisor|manager|super-admin')
        ) {
            $validated['approved_by_id'] = auth()->user()->id;
        }

        $invoicePurchase->update($validated);

        return redirect()
            ->route('invoice-purchases.index')
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\InvoicePurchase $invoicePurchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, InvoicePurchase $invoicePurchase)
    {
        $this->authorize('delete', $invoicePurchase);

        if ($invoicePurchase->image) {
            Storage::delete($invoicePurchase->image);
        }

        $invoicePurchase->delete();

        return redirect()
            ->route('invoice-purchases.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
