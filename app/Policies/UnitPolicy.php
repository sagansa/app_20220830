<?php

namespace App\Policies;

use App\Models\Unit;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UnitPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the unit can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list units');
    }

    /**
     * Determine whether the unit can view the model.
     */
    public function view(User $user, Unit $model): bool
    {
        return $user->hasPermissionTo('view units');
    }

    /**
     * Determine whether the unit can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create units');
    }

    /**
     * Determine whether the unit can update the model.
     */
    public function update(User $user, Unit $model): bool
    {
        return $user->hasPermissionTo('update units');
    }

    /**
     * Determine whether the unit can delete the model.
     */
    public function delete(User $user, Unit $model): bool
    {
        return $user->hasPermissionTo('delete units');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete units');
    }

    /**
     * Determine whether the unit can restore the model.
     */
    public function restore(User $user, Unit $model): bool
    {
        return false;
    }

    /**
     * Determine whether the unit can permanently delete the model.
     */
    public function forceDelete(User $user, Unit $model): bool
    {
        return false;
    }
}
