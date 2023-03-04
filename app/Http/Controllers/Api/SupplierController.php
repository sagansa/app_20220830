<?php

namespace App\Http\Controllers\Api;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\SupplierResource;
use App\Http\Resources\SupplierCollection;
use App\Http\Requests\SupplierStoreRequest;
use App\Http\Requests\SupplierUpdateRequest;

class SupplierController extends Controller
{
    public function index(Request $request): SupplierCollection
    {
        $this->authorize('view-any', Supplier::class);

        $search = $request->get('search', '');

        $suppliers = Supplier::search($search)
            ->latest()
            ->paginate();

        return new SupplierCollection($suppliers);
    }

    public function store(SupplierStoreRequest $request): SupplierResource
    {
        $this->authorize('create', Supplier::class);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $supplier = Supplier::create($validated);

        return new SupplierResource($supplier);
    }

    public function show(Request $request, Supplier $supplier): SupplierResource
    {
        $this->authorize('view', $supplier);

        return new SupplierResource($supplier);
    }

    public function update(
        SupplierUpdateRequest $request,
        Supplier $supplier
    ): SupplierResource {
        $this->authorize('update', $supplier);

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($supplier->image) {
                Storage::delete($supplier->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        $supplier->update($validated);

        return new SupplierResource($supplier);
    }

    public function destroy(Request $request, Supplier $supplier): Response
    {
        $this->authorize('delete', $supplier);

        if ($supplier->image) {
            Storage::delete($supplier->image);
        }

        $supplier->delete();

        return response()->noContent();
    }
}
