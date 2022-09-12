<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Store;
use Illuminate\Http\Request;
use App\Models\RequestPurchase;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RequestPurchaseStoreRequest;
use App\Http\Requests\RequestPurchaseUpdateRequest;

class RequestPurchaseController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', RequestPurchase::class);

        $search = $request->get('search', '');

        $requestPurchases = RequestPurchase::search($search)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        if(Auth::user()->hasRole('supervisor|staff')) {
            $requestPurchases->where('user_id', '=', Auth::user()->id);
        }

        return view(
            'app.request_purchases.index',
            compact('requestPurchases', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $stores = Store::orderBy('nickname', 'asc')
            ->whereNotIn('status', ['8'])
            ->pluck('name', 'id');
        $users = User::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');

        return view('app.request_purchases.create', compact('stores', 'users'));
    }

    /**
     * @param \App\Http\Requests\RequestPurchaseStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequestPurchaseStoreRequest $request)
    {
        $this->authorize('create', RequestPurchase::class);

        $validated = $request->validated();

        $validated['user_id'] = auth()->user()->id;

        $requestPurchase = RequestPurchase::create($validated);

        return redirect()
            ->route('request-purchases.edit', $requestPurchase)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\RequestPurchase $requestPurchase
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, RequestPurchase $requestPurchase)
    {
        $this->authorize('view', $requestPurchase);

        return view('app.request_purchases.show', compact('requestPurchase'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\RequestPurchase $requestPurchase
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, RequestPurchase $requestPurchase)
    {
        $this->authorize('update', $requestPurchase);

        $stores = Store::orderBy('nickname', 'asc')
            ->whereNotIn('status', ['8'])
            ->pluck('name', 'id');
        $users = User::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');

        return view(
            'app.request_purchases.edit',
            compact('requestPurchase', 'stores', 'users')
        );
    }

    /**
     * @param \App\Http\Requests\RequestPurchaseUpdateRequest $request
     * @param \App\Models\RequestPurchase $requestPurchase
     * @return \Illuminate\Http\Response
     */
    public function update(
        RequestPurchaseUpdateRequest $request,
        RequestPurchase $requestPurchase
    ) {
        $this->authorize('update', $requestPurchase);

        $validated = $request->validated();

        $requestPurchase->update($validated);

        return redirect()
            ->route('request-purchases.index')
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\RequestPurchase $requestPurchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, RequestPurchase $requestPurchase)
    {
        $this->authorize('delete', $requestPurchase);

        $requestPurchase->delete();

        return redirect()
            ->route('request-purchases.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
