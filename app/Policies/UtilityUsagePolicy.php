<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UtilityUsage;
use Illuminate\Auth\Access\HandlesAuthorization;

class UtilityUsagePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the utilityUsage can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list utilityusages');
    }

    /**
     * Determine whether the utilityUsage can view the model.
     */
    public function view(User $user, UtilityUsage $model): bool
    {
        return $user->hasPermissionTo('view utilityusages');
    }

    /**
     * Determine whether the utilityUsage can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create utilityusages');
    }

    /**
     * Determine whether the utilityUsage can update the model.
     */
    public function update(User $user, UtilityUsage $model): bool
    {
        return $user->hasPermissionTo('update utilityusages');
    }

    /**
     * Determine whether the utilityUsage can delete the model.
     */
    public function delete(User $user, UtilityUsage $model): bool
    {
        return $user->hasPermissionTo('delete utilityusages');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete utilityusages');
    }

    /**
     * Determine whether the utilityUsage can restore the model.
     */
    public function restore(User $user, UtilityUsage $model): bool
    {
        return false;
    }

    /**
     * Determine whether the utilityUsage can permanently delete the model.
     */
    public function forceDelete(User $user, UtilityUsage $model): bool
    {
        return false;
    }
}
