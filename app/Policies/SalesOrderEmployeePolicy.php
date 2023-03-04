<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SalesOrderEmployee;
use Illuminate\Auth\Access\HandlesAuthorization;

class SalesOrderEmployeePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the salesOrderEmployee can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list salesorderemployees');
    }

    /**
     * Determine whether the salesOrderEmployee can view the model.
     */
    public function view(User $user, SalesOrderEmployee $model): bool
    {
        return $user->hasPermissionTo('view salesorderemployees');
    }

    /**
     * Determine whether the salesOrderEmployee can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create salesorderemployees');
    }

    /**
     * Determine whether the salesOrderEmployee can update the model.
     */
    public function update(User $user, SalesOrderEmployee $model): bool
    {
        return $user->hasPermissionTo('update salesorderemployees');
    }

    /**
     * Determine whether the salesOrderEmployee can delete the model.
     */
    public function delete(User $user, SalesOrderEmployee $model): bool
    {
        return $user->hasPermissionTo('delete salesorderemployees');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete salesorderemployees');
    }

    /**
     * Determine whether the salesOrderEmployee can restore the model.
     */
    public function restore(User $user, SalesOrderEmployee $model): bool
    {
        return false;
    }

    /**
     * Determine whether the salesOrderEmployee can permanently delete the model.
     */
    public function forceDelete(User $user, SalesOrderEmployee $model): bool
    {
        return false;
    }
}
