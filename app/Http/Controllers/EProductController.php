<?php

namespace App\Http\Controllers;

use Image;
use App\Models\Store;
use App\Models\Product;
use App\Models\EProduct;
use Illuminate\Http\Request;
use App\Models\OnlineCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
            ->paginate(10)
            ->withQueryString();

        return view('app.e_products.index', compact('eProducts', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $products = Product::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $onlineCategories = OnlineCategory::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $stores = Store::orderBy('nickname', 'asc')
            ->whereNotIn('status', ['8'])
            ->pluck('nickname', 'id');

        return view(
            'app.e_products.create',
            compact('products', 'onlineCategories', 'stores')
        );
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
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $fileimage = rand() . time() . '.' . $extension;
            $file->move('storage/', $fileimage);
            Image::make('storage/' . $fileimage)
                ->resize(1200, 1200, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save();

            $validated['image'] = $fileimage;
        }

        $validated['created_by_id'] = auth()->user()->id;
        $validated['status'] = '1';

        $eProduct = EProduct::create($validated);

        return redirect()
            ->route('e-products.edit', $eProduct)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\EProduct $eProduct
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, EProduct $eProduct)
    {
        $this->authorize('view', $eProduct);

        return view('app.e_products.show', compact('eProduct'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\EProduct $eProduct
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, EProduct $eProduct)
    {
        $this->authorize('update', $eProduct);

        $products = Product::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $onlineCategories = OnlineCategory::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $stores = Store::orderBy('nickname', 'asc')
            ->whereNotIn('status', ['8'])
            ->pluck('nickname', 'id');

        return view(
            'app.e_products.edit',
            compact('eProduct', 'products', 'onlineCategories', 'stores')
        );
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
            $file = $request->file('image');
            $eProduct->delete_image();
            $extension = $file->getClientOriginalExtension();
            $file_image = rand() . time() . '.' . $extension;
            $file->move('storage/', $file_image);
            Image::make('storage/' . $file_image)
                ->resize(1200, 1200, function ($constraint) {
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

        $eProduct->update($validated);

        return redirect()
            ->route('e-products.index')
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('e-products.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
