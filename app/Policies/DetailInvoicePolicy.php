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
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list detailinvoices');
    }

    /**
     * Determine whether the detailInvoice can view the model.
     */
    public function view(User $user, DetailInvoice $model): bool
    {
        return $user->hasPermissionTo('view detailinvoices');
    }

    /**
     * Determine whether the detailInvoice can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create detailinvoices');
    }

    /**
     * Determine whether the detailInvoice can update the model.
     */
    public function update(User $user, DetailInvoice $model): bool
    {
        return $user->hasPermissionTo('update detailinvoices');
    }

    /**
     * Determine whether the detailInvoice can delete the model.
     */
    public function delete(User $user, DetailInvoice $model): bool
    {
        return $user->hasPermissionTo('delete detailinvoices');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete detailinvoices');
    }

    /**
     * Determine whether the detailInvoice can restore the model.
     */
    public function restore(User $user, DetailInvoice $model): bool
    {
        return false;
    }

    /**
     * Determine whether the detailInvoice can permanently delete the model.
     */
    public function forceDelete(User $user, DetailInvoice $model): bool
    {
        return false;
    }
}
