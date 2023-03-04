<?php

namespace App\Policies;

use App\Models\User;
use App\Models\AdminCashless;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminCashlessPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the adminCashless can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list admincashlesses');
    }

    /**
     * Determine whether the adminCashless can view the model.
     */
    public function view(User $user, AdminCashless $model): bool
    {
        return $user->hasPermissionTo('view admincashlesses');
    }

    /**
     * Determine whether the adminCashless can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create admincashlesses');
    }

    /**
     * Determine whether the adminCashless can update the model.
     */
    public function update(User $user, AdminCashless $model): bool
    {
        return $user->hasPermissionTo('update admincashlesses');
    }

    /**
     * Determine whether the adminCashless can delete the model.
     */
    public function delete(User $user, AdminCashless $model): bool
    {
        return $user->hasPermissionTo('delete admincashlesses');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete admincashlesses');
    }

    /**
     * Determine whether the adminCashless can restore the model.
     */
    public function restore(User $user, AdminCashless $model): bool
    {
        return false;
    }

    /**
     * Determine whether the adminCashless can permanently delete the model.
     */
    public function forceDelete(User $user, AdminCashless $model): bool
    {
        return false;
    }
}
