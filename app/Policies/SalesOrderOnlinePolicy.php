<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SalesOrderOnline;
use Illuminate\Auth\Access\HandlesAuthorization;

class SalesOrderOnlinePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the salesOrderOnline can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list salesorderonlines');
    }

    /**
     * Determine whether the salesOrderOnline can view the model.
     */
    public function view(User $user, SalesOrderOnline $model): bool
    {
        return $user->hasPermissionTo('view salesorderonlines');
    }

    /**
     * Determine whether the salesOrderOnline can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create salesorderonlines');
    }

    /**
     * Determine whether the salesOrderOnline can update the model.
     */
    public function update(User $user, SalesOrderOnline $model): bool
    {
        return $user->hasPermissionTo('update salesorderonlines');
    }

    /**
     * Determine whether the salesOrderOnline can delete the model.
     */
    public function delete(User $user, SalesOrderOnline $model): bool
    {
        return $user->hasPermissionTo('delete salesorderonlines');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete salesorderonlines');
    }

    /**
     * Determine whether the salesOrderOnline can restore the model.
     */
    public function restore(User $user, SalesOrderOnline $model): bool
    {
        return false;
    }

    /**
     * Determine whether the salesOrderOnline can permanently delete the model.
     */
    public function forceDelete(User $user, SalesOrderOnline $model): bool
    {
        return false;
    }
}
