<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SalesOrderDirectProduct;
use Illuminate\Auth\Access\HandlesAuthorization;

class SalesOrderDirectProductPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the salesOrderDirectProduct can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list salesorderdirects');
    }

    /**
     * Determine whether the salesOrderDirectProduct can view the model.
     */
    public function view(User $user, SalesOrderDirectProduct $model): bool
    {
        return $user->hasPermissionTo('view salesorderdirects');
    }

    /**
     * Determine whether the salesOrderDirectProduct can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create salesorderdirects');
    }

    /**
     * Determine whether the salesOrderDirectProduct can update the model.
     */
    public function update(User $user, SalesOrderDirectProduct $model): bool
    {
        return $user->hasPermissionTo('update salesorderdirects');
    }

    /**
     * Determine whether the salesOrderDirectProduct can delete the model.
     */
    public function delete(User $user, SalesOrderDirectProduct $model): bool
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
     * Determine whether the salesOrderDirectProduct can restore the model.
     */
    public function restore(User $user, SalesOrderDirectProduct $model): bool
    {
        return false;
    }

    /**
     * Determine whether the salesOrderDirectProduct can permanently delete the model.
     */
    public function forceDelete(
        User $user,
        SalesOrderDirectProduct $model
    ): bool {
        return false;
    }
}
