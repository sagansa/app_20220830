<?php

namespace App\Http\Controllers;

use Image;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CouponStoreRequest;
use App\Http\Requests\CouponUpdateRequest;

class CouponController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Coupon::class);

        $search = $request->get('search', '');

        $coupons = Coupon::search($search)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('app.coupons.index', compact('coupons', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('app.coupons.create');
    }

    /**
     * @param \App\Http\Requests\CouponStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CouponStoreRequest $request)
    {
        $this->authorize('create', Coupon::class);

        $validated = $request->validated();

        $validated['created_by_id'] = auth()->user()->id;
        $validated['status'] = '1';

        $coupon = Coupon::create($validated);

        return redirect()
            ->route('coupons.edit', $coupon)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Coupon $coupon
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Coupon $coupon)
    {
        $this->authorize('view', $coupon);

        return view('app.coupons.show', compact('coupon'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Coupon $coupon
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Coupon $coupon)
    {
        $this->authorize('update', $coupon);

        return view('app.coupons.edit', compact('coupon'));
    }

    /**
     * @param \App\Http\Requests\CouponUpdateRequest $request
     * @param \App\Models\Coupon $coupon
     * @return \Illuminate\Http\Response
     */
    public function update(CouponUpdateRequest $request, Coupon $coupon)
    {
        $this->authorize('update', $coupon);

        $validated = $request->validated();

        if (
            auth()
                ->user()
                ->hasRole('supervisor|manager|super-admin')
        ) {
            $validated['approved_by_id'] = auth()->user()->id;
        }

        $coupon->update($validated);

        return redirect()
            ->route('coupons.index')
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Coupon $coupon
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Coupon $coupon)
    {
        $this->authorize('delete', $coupon);

        $coupon->delete();

        return redirect()
            ->route('coupons.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
