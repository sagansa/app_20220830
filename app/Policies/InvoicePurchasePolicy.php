<?php

namespace App\Policies;

use App\Models\User;
use App\Models\InvoicePurchase;
use Illuminate\Auth\Access\HandlesAuthorization;

class InvoicePurchasePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the invoicePurchase can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list invoicepurchases');
    }

    /**
     * Determine whether the invoicePurchase can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\InvoicePurchase  $model
     * @return mixed
     */
    public function view(User $user, InvoicePurchase $model)
    {
        return $user->hasPermissionTo('view invoicepurchases');
    }

    /**
     * Determine whether the invoicePurchase can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create invoicepurchases');
    }

    /**
     * Determine whether the invoicePurchase can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\InvoicePurchase  $model
     * @return mixed
     */
    public function update(User $user, InvoicePurchase $model)
    {
        return $user->hasPermissionTo('update invoicepurchases');
    }

    /**
     * Determine whether the invoicePurchase can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\InvoicePurchase  $model
     * @return mixed
     */
    public function delete(User $user, InvoicePurchase $model)
    {
        return $user->hasPermissionTo('delete invoicepurchases');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\InvoicePurchase  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete invoicepurchases');
    }

    /**
     * Determine whether the invoicePurchase can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\InvoicePurchase  $model
     * @return mixed
     */
    public function restore(User $user, InvoicePurchase $model)
    {
        return false;
    }

    /**
     * Determine whether the invoicePurchase can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\InvoicePurchase  $model
     * @return mixed
     */
    public function forceDelete(User $user, InvoicePurchase $model)
    {
        return false;
    }
}
