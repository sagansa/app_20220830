<?php

namespace App\Policies;

use App\Models\User;
use App\Models\DetailInvoice;
use Illuminate\Auth\Access\HandlesAuthorization;

class DetailInvoicePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the detailInvoice can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list detailinvoices');
    }

    /**
     * Determine whether the detailInvoice can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DetailInvoice  $model
     * @return mixed
     */
    public function view(User $user, DetailInvoice $model)
    {
        return $user->hasPermissionTo('view detailinvoices');
    }

    /**
     * Determine whether the detailInvoice can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create detailinvoices');
    }

    /**
     * Determine whether the detailInvoice can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DetailInvoice  $model
     * @return mixed
     */
    public function update(User $user, DetailInvoice $model)
    {
        return $user->hasPermissionTo('update detailinvoices');
    }

    /**
     * Determine whether the detailInvoice can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DetailInvoice  $model
     * @return mixed
     */
    public function delete(User $user, DetailInvoice $model)
    {
        return $user->hasPermissionTo('delete detailinvoices');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DetailInvoice  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete detailinvoices');
    }

    /**
     * Determine whether the detailInvoice can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DetailInvoice  $model
     * @return mixed
     */
    public function restore(User $user, DetailInvoice $model)
    {
        return false;
    }

    /**
     * Determine whether the detailInvoice can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DetailInvoice  $model
     * @return mixed
     */
    public function forceDelete(User $user, DetailInvoice $model)
    {
        return false;
    }
}
