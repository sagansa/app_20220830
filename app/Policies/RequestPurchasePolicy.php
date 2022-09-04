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
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list requestpurchases');
    }

    /**
     * Determine whether the requestPurchase can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\RequestPurchase  $model
     * @return mixed
     */
    public function view(User $user, RequestPurchase $model)
    {
        return $user->hasPermissionTo('view requestpurchases');
    }

    /**
     * Determine whether the requestPurchase can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create requestpurchases');
    }

    /**
     * Determine whether the requestPurchase can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\RequestPurchase  $model
     * @return mixed
     */
    public function update(User $user, RequestPurchase $model)
    {
        return $user->hasPermissionTo('update requestpurchases');
    }

    /**
     * Determine whether the requestPurchase can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\RequestPurchase  $model
     * @return mixed
     */
    public function delete(User $user, RequestPurchase $model)
    {
        return $user->hasPermissionTo('delete requestpurchases');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\RequestPurchase  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete requestpurchases');
    }

    /**
     * Determine whether the requestPurchase can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\RequestPurchase  $model
     * @return mixed
     */
    public function restore(User $user, RequestPurchase $model)
    {
        return false;
    }

    /**
     * Determine whether the requestPurchase can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\RequestPurchase  $model
     * @return mixed
     */
    public function forceDelete(User $user, RequestPurchase $model)
    {
        return false;
    }
}
