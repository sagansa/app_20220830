<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SalesOrderDirect;
use Illuminate\Auth\Access\HandlesAuthorization;

class SalesOrderDirectPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the salesOrderDirect can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list salesorderdirects');
    }

    /**
     * Determine whether the salesOrderDirect can view the model.
     */
    public function view(User $user, SalesOrderDirect $model): bool
    {
        return $user->hasPermissionTo('view salesorderdirects');
    }

    /**
     * Determine whether the salesOrderDirect can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create salesorderdirects');
    }

    /**
     * Determine whether the salesOrderDirect can update the model.
     */
    public function update(User $user, SalesOrderDirect $model): bool
    {
        return $user->hasPermissionTo('update salesorderdirects');
    }

    /**
     * Determine whether the salesOrderDirect can delete the model.
     */
    public function delete(User $user, SalesOrderDirect $model): bool
    {
        return $user->hasPermissionTo('delete salesorderdirects');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete salesorderdirects');
    }

    /**
     * Determine whether the salesOrderDirect can restore the model.
     */
    public function restore(User $user, SalesOrderDirect $model): bool
    {
        return false;
    }

    /**
     * Determine whether the salesOrderDirect can permanently delete the model.
     */
    public function forceDelete(User $user, SalesOrderDirect $model): bool
    {
        return false;
    }
}
