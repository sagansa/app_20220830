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
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list invoicepurchases');
    }

    /**
     * Determine whether the invoicePurchase can view the model.
     */
    public function view(User $user, InvoicePurchase $model): bool
    {
        return $user->hasPermissionTo('view invoicepurchases');
    }

    /**
     * Determine whether the invoicePurchase can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create invoicepurchases');
    }

    /**
     * Determine whether the invoicePurchase can update the model.
     */
    public function update(User $user, InvoicePurchase $model): bool
    {
        return $user->hasPermissionTo('update invoicepurchases');
    }

    /**
     * Determine whether the invoicePurchase can delete the model.
     */
    public function delete(User $user, InvoicePurchase $model): bool
    {
        return $user->hasPermissionTo('delete invoicepurchases');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete invoicepurchases');
    }

    /**
     * Determine whether the invoicePurchase can restore the model.
     */
    public function restore(User $user, InvoicePurchase $model): bool
    {
        return false;
    }

    /**
     * Determine whether the invoicePurchase can permanently delete the model.
     */
    public function forceDelete(User $user, InvoicePurchase $model): bool
    {
        return false;
    }
}
