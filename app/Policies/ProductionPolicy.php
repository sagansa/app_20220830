<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Production;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the production can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list productions');
    }

    /**
     * Determine whether the production can view the model.
     */
    public function view(User $user, Production $model): bool
    {
        return $user->hasPermissionTo('view productions');
    }

    /**
     * Determine whether the production can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create productions');
    }

    /**
     * Determine whether the production can update the model.
     */
    public function update(User $user, Production $model): bool
    {
        return $user->hasPermissionTo('update productions');
    }

    /**
     * Determine whether the production can delete the model.
     */
    public function delete(User $user, Production $model): bool
    {
        return $user->hasPermissionTo('delete productions');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete productions');
    }

    /**
     * Determine whether the production can restore the model.
     */
    public function restore(User $user, Production $model): bool
    {
        return false;
    }

    /**
     * Determine whether the production can permanently delete the model.
     */
    public function forceDelete(User $user, Production $model): bool
    {
        return false;
    }
}
