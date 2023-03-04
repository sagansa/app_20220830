<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Cashless;
use Illuminate\Auth\Access\HandlesAuthorization;

class CashlessPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the cashless can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list cashlesses');
    }

    /**
     * Determine whether the cashless can view the model.
     */
    public function view(User $user, Cashless $model): bool
    {
        return $user->hasPermissionTo('view cashlesses');
    }

    /**
     * Determine whether the cashless can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create cashlesses');
    }

    /**
     * Determine whether the cashless can update the model.
     */
    public function update(User $user, Cashless $model): bool
    {
        return $user->hasPermissionTo('update cashlesses');
    }

    /**
     * Determine whether the cashless can delete the model.
     */
    public function delete(User $user, Cashless $model): bool
    {
        return $user->hasPermissionTo('delete cashlesses');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete cashlesses');
    }

    /**
     * Determine whether the cashless can restore the model.
     */
    public function restore(User $user, Cashless $model): bool
    {
        return false;
    }

    /**
     * Determine whether the cashless can permanently delete the model.
     */
    public function forceDelete(User $user, Cashless $model): bool
    {
        return false;
    }
}
