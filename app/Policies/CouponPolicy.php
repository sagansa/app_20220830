<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Coupon;
use Illuminate\Auth\Access\HandlesAuthorization;

class CouponPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the coupon can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list coupons');
    }

    /**
     * Determine whether the coupon can view the model.
     */
    public function view(User $user, Coupon $model): bool
    {
        return $user->hasPermissionTo('view coupons');
    }

    /**
     * Determine whether the coupon can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create coupons');
    }

    /**
     * Determine whether the coupon can update the model.
     */
    public function update(User $user, Coupon $model): bool
    {
        return $user->hasPermissionTo('update coupons');
    }

    /**
     * Determine whether the coupon can delete the model.
     */
    public function delete(User $user, Coupon $model): bool
    {
        return $user->hasPermissionTo('delete coupons');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete coupons');
    }

    /**
     * Determine whether the coupon can restore the model.
     */
    public function restore(User $user, Coupon $model): bool
    {
        return false;
    }

    /**
     * Determine whether the coupon can permanently delete the model.
     */
    public function forceDelete(User $user, Coupon $model): bool
    {
        return false;
    }
}
