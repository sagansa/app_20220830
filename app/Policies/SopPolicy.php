<?php

namespace App\Policies;

use App\Models\Sop;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SopPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the sop can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list sops');
    }

    /**
     * Determine whether the sop can view the model.
     */
    public function view(User $user, Sop $model): bool
    {
        return $user->hasPermissionTo('view sops');
    }

    /**
     * Determine whether the sop can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create sops');
    }

    /**
     * Determine whether the sop can update the model.
     */
    public function update(User $user, Sop $model): bool
    {
        return $user->hasPermissionTo('update sops');
    }

    /**
     * Determine whether the sop can delete the model.
     */
    public function delete(User $user, Sop $model): bool
    {
        return $user->hasPermissionTo('delete sops');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete sops');
    }

    /**
     * Determine whether the sop can restore the model.
     */
    public function restore(User $user, Sop $model): bool
    {
        return false;
    }

    /**
     * Determine whether the sop can permanently delete the model.
     */
    public function forceDelete(User $user, Sop $model): bool
    {
        return false;
    }
}
