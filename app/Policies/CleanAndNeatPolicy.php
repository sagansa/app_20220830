<?php

namespace App\Policies;

use App\Models\User;
use App\Models\CleanAndNeat;
use Illuminate\Auth\Access\HandlesAuthorization;

class CleanAndNeatPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the cleanAndNeat can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list cleanandneats');
    }

    /**
     * Determine whether the cleanAndNeat can view the model.
     */
    public function view(User $user, CleanAndNeat $model): bool
    {
        return $user->hasPermissionTo('view cleanandneats');
    }

    /**
     * Determine whether the cleanAndNeat can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create cleanandneats');
    }

    /**
     * Determine whether the cleanAndNeat can update the model.
     */
    public function update(User $user, CleanAndNeat $model): bool
    {
        return $user->hasPermissionTo('update cleanandneats');
    }

    /**
     * Determine whether the cleanAndNeat can delete the model.
     */
    public function delete(User $user, CleanAndNeat $model): bool
    {
        return $user->hasPermissionTo('delete cleanandneats');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete cleanandneats');
    }

    /**
     * Determine whether the cleanAndNeat can restore the model.
     */
    public function restore(User $user, CleanAndNeat $model): bool
    {
        return false;
    }

    /**
     * Determine whether the cleanAndNeat can permanently delete the model.
     */
    public function forceDelete(User $user, CleanAndNeat $model): bool
    {
        return false;
    }
}
