<?php

namespace App\Policies;

use App\Models\User;
use App\Models\PermitEmployee;
use Illuminate\Auth\Access\HandlesAuthorization;

class PermitEmployeePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the permitEmployee can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list permitemployees');
    }

    /**
     * Determine whether the permitEmployee can view the model.
     */
    public function view(User $user, PermitEmployee $model): bool
    {
        return $user->hasPermissionTo('view permitemployees');
    }

    /**
     * Determine whether the permitEmployee can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create permitemployees');
    }

    /**
     * Determine whether the permitEmployee can update the model.
     */
    public function update(User $user, PermitEmployee $model): bool
    {
        return $user->hasPermissionTo('update permitemployees');
    }

    /**
     * Determine whether the permitEmployee can delete the model.
     */
    public function delete(User $user, PermitEmployee $model): bool
    {
        return $user->hasPermissionTo('delete permitemployees');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete permitemployees');
    }

    /**
     * Determine whether the permitEmployee can restore the model.
     */
    public function restore(User $user, PermitEmployee $model): bool
    {
        return false;
    }

    /**
     * Determine whether the permitEmployee can permanently delete the model.
     */
    public function forceDelete(User $user, PermitEmployee $model): bool
    {
        return false;
    }
}
