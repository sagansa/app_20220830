<?php

namespace App\Policies;

use App\Models\User;
use App\Models\RequestPurchase;
use Illuminate\Auth\Access\HandlesAuthorization;

class RequestPurchasePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the requestPurchase can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list requestpurchases');
    }

    /**
     * Determine whether the requestPurchase can view the model.
     */
    public function view(User $user, RequestPurchase $model): bool
    {
        return $user->hasPermissionTo('view requestpurchases');
    }

    /**
     * Determine whether the requestPurchase can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create requestpurchases');
    }

    /**
     * Determine whether the requestPurchase can update the model.
     */
    public function update(User $user, RequestPurchase $model): bool
    {
        return $user->hasPermissionTo('update requestpurchases');
    }

    /**
     * Determine whether the requestPurchase can delete the model.
     */
    public function delete(User $user, RequestPurchase $model): bool
    {
        return $user->hasPermissionTo('delete requestpurchases');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete requestpurchases');
    }

    /**
     * Determine whether the requestPurchase can restore the model.
     */
    public function restore(User $user, RequestPurchase $model): bool
    {
        return false;
    }

    /**
     * Determine whether the requestPurchase can permanently delete the model.
     */
    public function forceDelete(User $user, RequestPurchase $model): bool
    {
        return false;
    }
}
