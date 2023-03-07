<?php

namespace App\Http\Controllers;

use Image;
use App\Models\User;
use App\Models\Store;
use Illuminate\Http\Request;
use App\Models\DeliveryService;
use App\Models\SalesOrderDirect;
use App\Models\TransferToAccount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\SalesOrderDirectStoreRequest;
use App\Http\Requests\SalesOrderDirectUpdateRequest;

class SalesOrderDirectController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', SalesOrderDirect::class);

        $search = $request->get('search', '');

        $salesOrderDirects = SalesOrderDirect::search($search)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'app.sales_order_directs.index',
            compact('salesOrderDirects', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $users = User::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $deliveryServices = DeliveryService::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $transferToAccounts = TransferToAccount::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $stores = Store::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');

        return view(
            'app.sales_order_directs.create',
            compact(
                'users',
                'deliveryServices',
                'transferToAccounts',
                'stores',
                'users'
            )
        );
    }

    /**
     * @param \App\Http\Requests\SalesOrderDirectStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SalesOrderDirectStoreRequest $request)
    {
        $this->authorize('create', SalesOrderDirect::class);

        $validated = $request->validated();

        if ($request->hasFile('image_transfer')) {
            $file = $request->file('image_transfer');
            $extension = $file->getClientOriginalExtension();
            $fileimage_transfer = rand() . time() . '.' . $extension;
            $file->move('storage/', $fileimage_transfer);
            Image::make('storage/' . $fileimage_transfer)
                ->resize(400, 400, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save();

            $validated['image_transfer'] = $fileimage_transfer;
        }

        if ($request->hasFile('sign')) {
            $file = $request->file('sign');
            $extension = $file->getClientOriginalExtension();
            $filesign = rand() . time() . '.' . $extension;
            $file->move('storage/', $filesign);
            Image::make('storage/' . $filesign)
                ->resize(400, 400, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save();

            $validated['sign'] = $filesign;
        }

        if ($request->hasFile('image_receipt')) {
            $file = $request->file('image_receipt');
            $extension = $file->getClientOriginalExtension();
            $fileimage_receipt = rand() . time() . '.' . $extension;
            $file->move('storage/', $fileimage_receipt);
            Image::make('storage/' . $fileimage_receipt)
                ->resize(400, 400, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save();

            $validated['image_receipt'] = $fileimage_receipt;
        }

        $validated['created_by_id'] = auth()->user()->id;
        $validated['status'] = '1';

        $salesOrderDirect = SalesOrderDirect::create($validated);

        return redirect()
            ->route('sales-order-directs.edit', $salesOrderDirect)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SalesOrderDirect $salesOrderDirect
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, SalesOrderDirect $salesOrderDirect)
    {
        $this->authorize('view', $salesOrderDirect);

        return view(
            'app.sales_order_directs.show',
            compact('salesOrderDirect')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SalesOrderDirect $salesOrderDirect
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, SalesOrderDirect $salesOrderDirect)
    {
        $this->authorize('update', $salesOrderDirect);

        $users = User::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $deliveryServices = DeliveryService::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $transferToAccounts = TransferToAccount::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $stores = Store::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');

        return view(
            'app.sales_order_directs.edit',
            compact(
                'salesOrderDirect',
                'users',
                'deliveryServices',
                'transferToAccounts',
                'stores',
                'users'
            )
        );
    }

    /**
     * @param \App\Http\Requests\SalesOrderDirectUpdateRequest $request
     * @param \App\Models\SalesOrderDirect $salesOrderDirect
     * @return \Illuminate\Http\Response
     */
    public function update(
        SalesOrderDirectUpdateRequest $request,
        SalesOrderDirect $salesOrderDirect
    ) {
        $this->authorize('update', $salesOrderDirect);

        $validated = $request->validated();
        if ($request->hasFile('image_transfer')) {
            $file = $request->file('image_transfer');
            $salesOrderDirect->delete_image_transfer();
            $extension = $file->getClientOriginalExtension();
            $file_image_transfer = rand() . time() . '.' . $extension;
            $file->move('storage/', $file_image_transfer);
            Image::make('storage/' . $file_image_transfer)
                ->resize(400, 400, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save();

            $validated['image_transfer'] = $file_image_transfer;
        }

        if ($request->hasFile('sign')) {
            $file = $request->file('sign');
            $salesOrderDirect->delete_sign();
            $extension = $file->getClientOriginalExtension();
            $file_sign = rand() . time() . '.' . $extension;
            $file->move('storage/', $file_sign);
            Image::make('storage/' . $file_sign)
                ->resize(400, 400, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save();

            $validated['sign'] = $file_sign;
        }

        if ($request->hasFile('image_receipt')) {
            $file = $request->file('image_receipt');
            $salesOrderDirect->delete_image_receipt();
            $extension = $file->getClientOriginalExtension();
            $file_image_receipt = rand() . time() . '.' . $extension;
            $file->move('storage/', $file_image_receipt);
            Image::make('storage/' . $file_image_receipt)
                ->resize(400, 400, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save();

            $validated['image_receipt'] = $file_image_receipt;
        }

        if (
            auth()
                ->user()
                ->hasRole('supervisor|manager|super-admin')
        ) {
            $validated['approved_by_id'] = auth()->user()->id;
        }

        $salesOrderDirect->update($validated);

        return redirect()
            ->route('sales-order-directs.index')
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SalesOrderDirect $salesOrderDirect
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        SalesOrderDirect $salesOrderDirect
    ) {
        $this->authorize('delete', $salesOrderDirect);

        if ($salesOrderDirect->image_transfer) {
            Storage::delete($salesOrderDirect->image_transfer);
        }

        if ($salesOrderDirect->sign) {
            Storage::delete($salesOrderDirect->sign);
        }

        if ($salesOrderDirect->image_receipt) {
            Storage::delete($salesOrderDirect->image_receipt);
        }

        $salesOrderDirect->delete();

        return redirect()
            ->route('sales-order-directs.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
