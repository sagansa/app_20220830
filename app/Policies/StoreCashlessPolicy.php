<?php

namespace App\Policies;

use App\Models\User;
use App\Models\StoreCashless;
use Illuminate\Auth\Access\HandlesAuthorization;

class StoreCashlessPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the storeCashless can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list storecashlesses');
    }

    /**
     * Determine whether the storeCashless can view the model.
     */
    public function view(User $user, StoreCashless $model): bool
    {
        return $user->hasPermissionTo('view storecashlesses');
    }

    /**
     * Determine whether the storeCashless can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create storecashlesses');
    }

    /**
     * Determine whether the storeCashless can update the model.
     */
    public function update(User $user, StoreCashless $model): bool
    {
        return $user->hasPermissionTo('update storecashlesses');
    }

    /**
     * Determine whether the storeCashless can delete the model.
     */
    public function delete(User $user, StoreCashless $model): bool
    {
        return $user->hasPermissionTo('delete storecashlesses');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete storecashlesses');
    }

    /**
     * Determine whether the storeCashless can restore the model.
     */
    public function restore(User $user, StoreCashless $model): bool
    {
        return false;
    }

    /**
     * Determine whether the storeCashless can permanently delete the model.
     */
    public function forceDelete(User $user, StoreCashless $model): bool
    {
        return false;
    }
}
