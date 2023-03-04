<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UtilityProvider;
use Illuminate\Auth\Access\HandlesAuthorization;

class UtilityProviderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the utilityProvider can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list utilityproviders');
    }

    /**
     * Determine whether the utilityProvider can view the model.
     */
    public function view(User $user, UtilityProvider $model): bool
    {
        return $user->hasPermissionTo('view utilityproviders');
    }

    /**
     * Determine whether the utilityProvider can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create utilityproviders');
    }

    /**
     * Determine whether the utilityProvider can update the model.
     */
    public function update(User $user, UtilityProvider $model): bool
    {
        return $user->hasPermissionTo('update utilityproviders');
    }

    /**
     * Determine whether the utilityProvider can delete the model.
     */
    public function delete(User $user, UtilityProvider $model): bool
    {
        return $user->hasPermissionTo('delete utilityproviders');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete utilityproviders');
    }

    /**
     * Determine whether the utilityProvider can restore the model.
     */
    public function restore(User $user, UtilityProvider $model): bool
    {
        return false;
    }

    /**
     * Determine whether the utilityProvider can permanently delete the model.
     */
    public function forceDelete(User $user, UtilityProvider $model): bool
    {
        return false;
    }
}
