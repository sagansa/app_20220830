<?php

namespace App\Http\Controllers;

use Image;
use Illuminate\Http\Request;
use App\Models\StoreCashless;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreCashlessStoreRequest;
use App\Http\Requests\StoreCashlessUpdateRequest;

class StoreCashlessController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', StoreCashless::class);

        $search = $request->get('search', '');

        $storeCashlesses = StoreCashless::search($search)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'app.store_cashlesses.index',
            compact('storeCashlesses', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('app.store_cashlesses.create');
    }

    /**
     * @param \App\Http\Requests\StoreCashlessStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCashlessStoreRequest $request)
    {
        $this->authorize('create', StoreCashless::class);

        $validated = $request->validated();

        $validated['created_by_id'] = auth()->user()->id;
        $validated['status'] = '1';

        $storeCashless = StoreCashless::create($validated);

        return redirect()
            ->route('store-cashlesses.edit', $storeCashless)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\StoreCashless $storeCashless
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, StoreCashless $storeCashless)
    {
        $this->authorize('view', $storeCashless);

        return view('app.store_cashlesses.show', compact('storeCashless'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\StoreCashless $storeCashless
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, StoreCashless $storeCashless)
    {
        $this->authorize('update', $storeCashless);

        return view('app.store_cashlesses.edit', compact('storeCashless'));
    }

    /**
     * @param \App\Http\Requests\StoreCashlessUpdateRequest $request
     * @param \App\Models\StoreCashless $storeCashless
     * @return \Illuminate\Http\Response
     */
    public function update(
        StoreCashlessUpdateRequest $request,
        StoreCashless $storeCashless
    ) {
        $this->authorize('update', $storeCashless);

        $validated = $request->validated();

        if (
            auth()
                ->user()
                ->hasRole('supervisor|manager|super-admin')
        ) {
            $validated['approved_by_id'] = auth()->user()->id;
        }

        $storeCashless->update($validated);

        return redirect()
            ->route('store-cashlesses.index')
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\StoreCashless $storeCashless
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, StoreCashless $storeCashless)
    {
        $this->authorize('delete', $storeCashless);

        $storeCashless->delete();

        return redirect()
            ->route('store-cashlesses.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
