<?php

namespace App\Http\Controllers\Api;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\CouponResource;
use App\Http\Resources\CouponCollection;
use App\Http\Requests\CouponStoreRequest;
use App\Http\Requests\CouponUpdateRequest;

class CouponController extends Controller
{
    public function index(Request $request): CouponCollection
    {
        $this->authorize('view-any', Coupon::class);

        $search = $request->get('search', '');

        $coupons = Coupon::search($search)
            ->latest()
            ->paginate();

        return new CouponCollection($coupons);
    }

    public function store(CouponStoreRequest $request): CouponResource
    {
        $this->authorize('create', Coupon::class);

        $validated = $request->validated();

        $coupon = Coupon::create($validated);

        return new CouponResource($coupon);
    }

    public function show(Request $request, Coupon $coupon): CouponResource
    {
        $this->authorize('view', $coupon);

        return new CouponResource($coupon);
    }

    public function update(
        CouponUpdateRequest $request,
        Coupon $coupon
    ): CouponResource {
        $this->authorize('update', $coupon);

        $validated = $request->validated();

        $coupon->update($validated);

        return new CouponResource($coupon);
    }

    public function destroy(Request $request, Coupon $coupon): Response
    {
        $this->authorize('delete', $coupon);

        $coupon->delete();

        return response()->noContent();
    }
}
