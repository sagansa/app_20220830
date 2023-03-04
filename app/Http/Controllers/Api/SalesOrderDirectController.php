<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\SalesOrderDirect;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\SalesOrderDirectResource;
use App\Http\Resources\SalesOrderDirectCollection;
use App\Http\Requests\SalesOrderDirectStoreRequest;
use App\Http\Requests\SalesOrderDirectUpdateRequest;

class SalesOrderDirectController extends Controller
{
    public function index(Request $request): SalesOrderDirectCollection
    {
        $this->authorize('view-any', SalesOrderDirect::class);

        $search = $request->get('search', '');

        $salesOrderDirects = SalesOrderDirect::search($search)
            ->latest()
            ->paginate();

        return new SalesOrderDirectCollection($salesOrderDirects);
    }

    public function store(
        SalesOrderDirectStoreRequest $request
    ): SalesOrderDirectResource {
        $this->authorize('create', SalesOrderDirect::class);

        $validated = $request->validated();
        if ($request->hasFile('sign')) {
            $validated['sign'] = $request->file('sign')->store('public');
        }

        if ($request->hasFile('image_transfer')) {
            $validated['image_transfer'] = $request
                ->file('image_transfer')
                ->store('public');
        }

        if ($request->hasFile('image_receipt')) {
            $validated['image_receipt'] = $request
                ->file('image_receipt')
                ->store('public');
        }

        $salesOrderDirect = SalesOrderDirect::create($validated);

        return new SalesOrderDirectResource($salesOrderDirect);
    }

    public function show(
        Request $request,
        SalesOrderDirect $salesOrderDirect
    ): SalesOrderDirectResource {
        $this->authorize('view', $salesOrderDirect);

        return new SalesOrderDirectResource($salesOrderDirect);
    }

    public function update(
        SalesOrderDirectUpdateRequest $request,
        SalesOrderDirect $salesOrderDirect
    ): SalesOrderDirectResource {
        $this->authorize('update', $salesOrderDirect);

        $validated = $request->validated();

        if ($request->hasFile('sign')) {
            if ($salesOrderDirect->sign) {
                Storage::delete($salesOrderDirect->sign);
            }

            $validated['sign'] = $request->file('sign')->store('public');
        }

        if ($request->hasFile('image_transfer')) {
            if ($salesOrderDirect->image_transfer) {
                Storage::delete($salesOrderDirect->image_transfer);
            }

            $validated['image_transfer'] = $request
                ->file('image_transfer')
                ->store('public');
        }

        if ($request->hasFile('image_receipt')) {
            if ($salesOrderDirect->image_receipt) {
                Storage::delete($salesOrderDirect->image_receipt);
            }

            $validated['image_receipt'] = $request
                ->file('image_receipt')
                ->store('public');
        }

        $salesOrderDirect->update($validated);

        return new SalesOrderDirectResource($salesOrderDirect);
    }

    public function destroy(
        Request $request,
        SalesOrderDirect $salesOrderDirect
    ): Response {
        $this->authorize('delete', $salesOrderDirect);

        if ($salesOrderDirect->sign) {
            Storage::delete($salesOrderDirect->sign);
        }

        if ($salesOrderDirect->image_transfer) {
            Storage::delete($salesOrderDirect->image_transfer);
        }

        if ($salesOrderDirect->image_receipt) {
            Storage::delete($salesOrderDirect->image_receipt);
        }

        $salesOrderDirect->delete();

        return response()->noContent();
    }
}
