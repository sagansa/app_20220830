<?php

namespace App\Http\Controllers;

use Image;
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
    public function index(Request $request)
    {
        $this->authorize('view-any', InvoicePurchase::class);

        $search = $request->get('search', '');

        $invoicePurchases = InvoicePurchase::search($search)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        if (Auth::user()->hasRole('staff|supervisor')) {
            $invoicePurchases->where('created_by_id', '=', Auth::user()->id);
        }

        return view(
            'app.invoice_purchases.index',
            compact('invoicePurchases', 'search')
        );
    }

    public function create(Request $request)
    {
        $paymentTypes = PaymentType::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $stores = Store::orderBy('nickname', 'asc')
            ->whereNotIn('status', ['8'])
            ->pluck('nickname', 'id');
        $suppliers = Supplier::orderBy('name', 'asc')
            ->get()
            ->pluck('supplier_name', 'id');

        return view(
            'app.invoice_purchases.create',
            compact('paymentTypes', 'stores', 'suppliers')
        );
    }

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
                ->resize(600, 600, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save();

            $validated['image'] = $fileimage;
        }

        $validated['created_by_id'] = auth()->user()->id;
        // $validated['payment_status'] = '1';
        // $validated['discounts'] = '0';
        // $validated['taxes'] = '0';

        $invoicePurchase = InvoicePurchase::create($validated);

        return redirect()
            ->route('invoice-purchases.edit', $invoicePurchase)
            ->withSuccess(__('crud.common.created'));
    }

    public function show(Request $request, InvoicePurchase $invoicePurchase)
    {
        $this->authorize('view', $invoicePurchase);

        return view('app.invoice_purchases.show', compact('invoicePurchase'));
    }

    public function edit(Request $request, InvoicePurchase $invoicePurchase)
    {
        $this->authorize('update', $invoicePurchase);

        $paymentTypes = PaymentType::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $stores = Store::orderBy('nickname', 'asc')
            ->whereNotIn('status', ['8'])
            ->pluck('nickname', 'id');
        $suppliers = Supplier::orderBy('name', 'asc')
            ->get()
            ->pluck('supplier_name', 'id');

        return view(
            'app.invoice_purchases.edit',
            compact('invoicePurchase', 'paymentTypes', 'stores', 'suppliers')
        );
    }

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
                ->resize(600, 600, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save();

            $validated['image'] = $file_image;
        }

        if (
            auth()
                ->user()
                ->hasRole('super-admin')
        ) {
            $validated['approved_by_id'] = auth()->user()->id;
        }

        $invoicePurchase->update($validated);

        // dd($validated);
        return redirect()
            ->route('invoice-purchases.index')
            ->withSuccess(__('crud.common.saved'));
    }

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
