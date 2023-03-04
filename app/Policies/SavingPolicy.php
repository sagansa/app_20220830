<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Saving;
use Illuminate\Auth\Access\HandlesAuthorization;

class SavingPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the saving can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list savings');
    }

    /**
     * Determine whether the saving can view the model.
     */
    public function view(User $user, Saving $model): bool
    {
        return $user->hasPermissionTo('view savings');
    }

    /**
     * Determine whether the saving can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create savings');
    }

    /**
     * Determine whether the saving can update the model.
     */
    public function update(User $user, Saving $model): bool
    {
        return $user->hasPermissionTo('update savings');
    }

    /**
     * Determine whether the saving can delete the model.
     */
    public function delete(User $user, Saving $model): bool
    {
        return $user->hasPermissionTo('delete savings');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete savings');
    }

    /**
     * Determine whether the saving can restore the model.
     */
    public function restore(User $user, Saving $model): bool
    {
        return false;
    }

    /**
     * Determine whether the saving can permanently delete the model.
     */
    public function forceDelete(User $user, Saving $model): bool
    {
        return false;
    }
}
