<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Utility;
use Illuminate\Auth\Access\HandlesAuthorization;

class UtilityPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the utility can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list utilities');
    }

    /**
     * Determine whether the utility can view the model.
     */
    public function view(User $user, Utility $model): bool
    {
        return $user->hasPermissionTo('view utilities');
    }

    /**
     * Determine whether the utility can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create utilities');
    }

    /**
     * Determine whether the utility can update the model.
     */
    public function update(User $user, Utility $model): bool
    {
        return $user->hasPermissionTo('update utilities');
    }

    /**
     * Determine whether the utility can delete the model.
     */
    public function delete(User $user, Utility $model): bool
    {
        return $user->hasPermissionTo('delete utilities');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete utilities');
    }

    /**
     * Determine whether the utility can restore the model.
     */
    public function restore(User $user, Utility $model): bool
    {
        return false;
    }

    /**
     * Determine whether the utility can permanently delete the model.
     */
    public function forceDelete(User $user, Utility $model): bool
    {
        return false;
    }
}
