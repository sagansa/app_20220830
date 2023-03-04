<?php

namespace App\Http\Controllers\Api;

use App\Models\EProduct;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\EProductResource;
use App\Http\Resources\EProductCollection;
use App\Http\Requests\EProductStoreRequest;
use App\Http\Requests\EProductUpdateRequest;

class EProductController extends Controller
{
    public function index(Request $request): EProductCollection
    {
        $this->authorize('view-any', EProduct::class);

        $search = $request->get('search', '');

        $eProducts = EProduct::search($search)
            ->latest()
            ->paginate();

        return new EProductCollection($eProducts);
    }

    public function store(EProductStoreRequest $request): EProductResource
    {
        $this->authorize('create', EProduct::class);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $eProduct = EProduct::create($validated);

        return new EProductResource($eProduct);
    }

    public function show(Request $request, EProduct $eProduct): EProductResource
    {
        $this->authorize('view', $eProduct);

        return new EProductResource($eProduct);
    }

    public function update(
        EProductUpdateRequest $request,
        EProduct $eProduct
    ): EProductResource {
        $this->authorize('update', $eProduct);

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($eProduct->image) {
                Storage::delete($eProduct->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        $eProduct->update($validated);

        return new EProductResource($eProduct);
    }

    public function destroy(Request $request, EProduct $eProduct): Response
    {
        $this->authorize('delete', $eProduct);

        if ($eProduct->image) {
            Storage::delete($eProduct->image);
        }

        $eProduct->delete();

        return response()->noContent();
    }
}
