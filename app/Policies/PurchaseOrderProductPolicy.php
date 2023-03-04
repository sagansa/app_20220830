<?php

namespace App\Policies;

use App\Models\User;
use App\Models\PurchaseOrderProduct;
use Illuminate\Auth\Access\HandlesAuthorization;

class PurchaseOrderProductPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the purchaseOrderProduct can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list purchaseorderproducts');
    }

    /**
     * Determine whether the purchaseOrderProduct can view the model.
     */
    public function view(User $user, PurchaseOrderProduct $model): bool
    {
        return $user->hasPermissionTo('view purchaseorderproducts');
    }

    /**
     * Determine whether the purchaseOrderProduct can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create purchaseorderproducts');
    }

    /**
     * Determine whether the purchaseOrderProduct can update the model.
     */
    public function update(User $user, PurchaseOrderProduct $model): bool
    {
        return $user->hasPermissionTo('update purchaseorderproducts');
    }

    /**
     * Determine whether the purchaseOrderProduct can delete the model.
     */
    public function delete(User $user, PurchaseOrderProduct $model): bool
    {
        return $user->hasPermissionTo('delete purchaseorderproducts');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete purchaseorderproducts');
    }

    /**
     * Determine whether the purchaseOrderProduct can restore the model.
     */
    public function restore(User $user, PurchaseOrderProduct $model): bool
    {
        return false;
    }

    /**
     * Determine whether the purchaseOrderProduct can permanently delete the model.
     */
    public function forceDelete(User $user, PurchaseOrderProduct $model): bool
    {
        return false;
    }
}
