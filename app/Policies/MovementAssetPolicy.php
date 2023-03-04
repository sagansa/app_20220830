<?php

namespace App\Policies;

use App\Models\User;
use App\Models\MovementAsset;
use Illuminate\Auth\Access\HandlesAuthorization;

class MovementAssetPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the movementAsset can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list movementassets');
    }

    /**
     * Determine whether the movementAsset can view the model.
     */
    public function view(User $user, MovementAsset $model): bool
    {
        return $user->hasPermissionTo('view movementassets');
    }

    /**
     * Determine whether the movementAsset can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create movementassets');
    }

    /**
     * Determine whether the movementAsset can update the model.
     */
    public function update(User $user, MovementAsset $model): bool
    {
        return $user->hasPermissionTo('update movementassets');
    }

    /**
     * Determine whether the movementAsset can delete the model.
     */
    public function delete(User $user, MovementAsset $model): bool
    {
        return $user->hasPermissionTo('delete movementassets');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete movementassets');
    }

    /**
     * Determine whether the movementAsset can restore the model.
     */
    public function restore(User $user, MovementAsset $model): bool
    {
        return false;
    }

    /**
     * Determine whether the movementAsset can permanently delete the model.
     */
    public function forceDelete(User $user, MovementAsset $model): bool
    {
        return false;
    }
}
