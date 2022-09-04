<?php

namespace App\Policies;

use App\Models\User;
use App\Models\DetailPurchase;
use Illuminate\Auth\Access\HandlesAuthorization;

class DetailPurchasePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the detailPurchase can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list detailpurchases');
    }

    /**
     * Determine whether the detailPurchase can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DetailPurchase  $model
     * @return mixed
     */
    public function view(User $user, DetailPurchase $model)
    {
        return $user->hasPermissionTo('view detailpurchases');
    }

    /**
     * Determine whether the detailPurchase can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create detailpurchases');
    }

    /**
     * Determine whether the detailPurchase can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DetailPurchase  $model
     * @return mixed
     */
    public function update(User $user, DetailPurchase $model)
    {
        return $user->hasPermissionTo('update detailpurchases');
    }

    /**
     * Determine whether the detailPurchase can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DetailPurchase  $model
     * @return mixed
     */
    public function delete(User $user, DetailPurchase $model)
    {
        return $user->hasPermissionTo('delete detailpurchases');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DetailPurchase  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete detailpurchases');
    }

    /**
     * Determine whether the detailPurchase can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DetailPurchase  $model
     * @return mixed
     */
    public function restore(User $user, DetailPurchase $model)
    {
        return false;
    }

    /**
     * Determine whether the detailPurchase can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DetailPurchase  $model
     * @return mixed
     */
    public function forceDelete(User $user, DetailPurchase $model)
    {
        return false;
    }
}
