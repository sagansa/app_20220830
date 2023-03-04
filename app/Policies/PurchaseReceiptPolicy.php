<?php

namespace App\Policies;

use App\Models\User;
use App\Models\PurchaseReceipt;
use Illuminate\Auth\Access\HandlesAuthorization;

class PurchaseReceiptPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the purchaseReceipt can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list purchasereceipts');
    }

    /**
     * Determine whether the purchaseReceipt can view the model.
     */
    public function view(User $user, PurchaseReceipt $model): bool
    {
        return $user->hasPermissionTo('view purchasereceipts');
    }

    /**
     * Determine whether the purchaseReceipt can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create purchasereceipts');
    }

    /**
     * Determine whether the purchaseReceipt can update the model.
     */
    public function update(User $user, PurchaseReceipt $model): bool
    {
        return $user->hasPermissionTo('update purchasereceipts');
    }

    /**
     * Determine whether the purchaseReceipt can delete the model.
     */
    public function delete(User $user, PurchaseReceipt $model): bool
    {
        return $user->hasPermissionTo('delete purchasereceipts');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete purchasereceipts');
    }

    /**
     * Determine whether the purchaseReceipt can restore the model.
     */
    public function restore(User $user, PurchaseReceipt $model): bool
    {
        return false;
    }

    /**
     * Determine whether the purchaseReceipt can permanently delete the model.
     */
    public function forceDelete(User $user, PurchaseReceipt $model): bool
    {
        return false;
    }
}
