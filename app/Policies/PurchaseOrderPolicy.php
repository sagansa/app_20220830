<?php

namespace App\Policies;

use App\Models\User;
use App\Models\PurchaseOrder;
use Illuminate\Auth\Access\HandlesAuthorization;

class PurchaseOrderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the purchaseOrder can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list purchaseorders');
    }

    /**
     * Determine whether the purchaseOrder can view the model.
     */
    public function view(User $user, PurchaseOrder $model): bool
    {
        return $user->hasPermissionTo('view purchaseorders');
    }

    /**
     * Determine whether the purchaseOrder can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create purchaseorders');
    }

    /**
     * Determine whether the purchaseOrder can update the model.
     */
    public function update(User $user, PurchaseOrder $model): bool
    {
        return $user->hasPermissionTo('update purchaseorders');
    }

    /**
     * Determine whether the purchaseOrder can delete the model.
     */
    public function delete(User $user, PurchaseOrder $model): bool
    {
        return $user->hasPermissionTo('delete purchaseorders');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete purchaseorders');
    }

    /**
     * Determine whether the purchaseOrder can restore the model.
     */
    public function restore(User $user, PurchaseOrder $model): bool
    {
        return false;
    }

    /**
     * Determine whether the purchaseOrder can permanently delete the model.
     */
    public function forceDelete(User $user, PurchaseOrder $model): bool
    {
        return false;
    }
}
