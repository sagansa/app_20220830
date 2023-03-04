<?php

namespace App\Policies;

use App\Models\User;
use App\Models\FranchiseGroup;
use Illuminate\Auth\Access\HandlesAuthorization;

class FranchiseGroupPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the franchiseGroup can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list franchisegroups');
    }

    /**
     * Determine whether the franchiseGroup can view the model.
     */
    public function view(User $user, FranchiseGroup $model): bool
    {
        return $user->hasPermissionTo('view franchisegroups');
    }

    /**
     * Determine whether the franchiseGroup can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create franchisegroups');
    }

    /**
     * Determine whether the franchiseGroup can update the model.
     */
    public function update(User $user, FranchiseGroup $model): bool
    {
        return $user->hasPermissionTo('update franchisegroups');
    }

    /**
     * Determine whether the franchiseGroup can delete the model.
     */
    public function delete(User $user, FranchiseGroup $model): bool
    {
        return $user->hasPermissionTo('delete franchisegroups');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete franchisegroups');
    }

    /**
     * Determine whether the franchiseGroup can restore the model.
     */
    public function restore(User $user, FranchiseGroup $model): bool
    {
        return false;
    }

    /**
     * Determine whether the franchiseGroup can permanently delete the model.
     */
    public function forceDelete(User $user, FranchiseGroup $model): bool
    {
        return false;
    }
}
