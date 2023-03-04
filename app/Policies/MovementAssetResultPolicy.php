<?php

namespace App\Policies;

use App\Models\User;
use App\Models\MovementAssetResult;
use Illuminate\Auth\Access\HandlesAuthorization;

class MovementAssetResultPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the movementAssetResult can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list movementassetresults');
    }

    /**
     * Determine whether the movementAssetResult can view the model.
     */
    public function view(User $user, MovementAssetResult $model): bool
    {
        return $user->hasPermissionTo('view movementassetresults');
    }

    /**
     * Determine whether the movementAssetResult can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create movementassetresults');
    }

    /**
     * Determine whether the movementAssetResult can update the model.
     */
    public function update(User $user, MovementAssetResult $model): bool
    {
        return $user->hasPermissionTo('update movementassetresults');
    }

    /**
     * Determine whether the movementAssetResult can delete the model.
     */
    public function delete(User $user, MovementAssetResult $model): bool
    {
        return $user->hasPermissionTo('delete movementassetresults');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete movementassetresults');
    }

    /**
     * Determine whether the movementAssetResult can restore the model.
     */
    public function restore(User $user, MovementAssetResult $model): bool
    {
        return false;
    }

    /**
     * Determine whether the movementAssetResult can permanently delete the model.
     */
    public function forceDelete(User $user, MovementAssetResult $model): bool
    {
        return false;
    }
}
