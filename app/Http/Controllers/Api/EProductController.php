<?php

namespace App\Http\Controllers\Api;

use App\Models\EProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\EProductResource;
use App\Http\Resources\EProductCollection;
use App\Http\Requests\EProductStoreRequest;
use App\Http\Requests\EProductUpdateRequest;

class EProductController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', EProduct::class);

        $search = $request->get('search', '');

        $eProducts = EProduct::search($search)
            ->latest()
            ->paginate();

        return new EProductCollection($eProducts);
    }

    /**
     * @param \App\Http\Requests\EProductStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(EProductStoreRequest $request)
    {
        $this->authorize('create', EProduct::class);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $eProduct = EProduct::create($validated);

        return new EProductResource($eProduct);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\EProduct $eProduct
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, EProduct $eProduct)
    {
        $this->authorize('view', $eProduct);

        return new EProductResource($eProduct);
    }

    /**
     * @param \App\Http\Requests\EProductUpdateRequest $request
     * @param \App\Models\EProduct $eProduct
     * @return \Illuminate\Http\Response
     */
    public function update(EProductUpdateRequest $request, EProduct $eProduct)
    {
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

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\EProduct $eProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, EProduct $eProduct)
    {
        $this->authorize('delete', $eProduct);

        if ($eProduct->image) {
            Storage::delete($eProduct->image);
        }

        $eProduct->delete();

        return response()->noContent();
    }
}
