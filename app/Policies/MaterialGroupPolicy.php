<?php

namespace App\Policies;

use App\Models\User;
use App\Models\MaterialGroup;
use Illuminate\Auth\Access\HandlesAuthorization;

class MaterialGroupPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the materialGroup can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list materialgroups');
    }

    /**
     * Determine whether the materialGroup can view the model.
     */
    public function view(User $user, MaterialGroup $model): bool
    {
        return $user->hasPermissionTo('view materialgroups');
    }

    /**
     * Determine whether the materialGroup can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create materialgroups');
    }

    /**
     * Determine whether the materialGroup can update the model.
     */
    public function update(User $user, MaterialGroup $model): bool
    {
        return $user->hasPermissionTo('update materialgroups');
    }

    /**
     * Determine whether the materialGroup can delete the model.
     */
    public function delete(User $user, MaterialGroup $model): bool
    {
        return $user->hasPermissionTo('delete materialgroups');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete materialgroups');
    }

    /**
     * Determine whether the materialGroup can restore the model.
     */
    public function restore(User $user, MaterialGroup $model): bool
    {
        return false;
    }

    /**
     * Determine whether the materialGroup can permanently delete the model.
     */
    public function forceDelete(User $user, MaterialGroup $model): bool
    {
        return false;
    }
}
