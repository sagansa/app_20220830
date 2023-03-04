<?php

namespace App\Policies;

use App\Models\User;
use App\Models\MovementAssetAudit;
use Illuminate\Auth\Access\HandlesAuthorization;

class MovementAssetAuditPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the movementAssetAudit can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list movementassetaudits');
    }

    /**
     * Determine whether the movementAssetAudit can view the model.
     */
    public function view(User $user, MovementAssetAudit $model): bool
    {
        return $user->hasPermissionTo('view movementassetaudits');
    }

    /**
     * Determine whether the movementAssetAudit can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create movementassetaudits');
    }

    /**
     * Determine whether the movementAssetAudit can update the model.
     */
    public function update(User $user, MovementAssetAudit $model): bool
    {
        return $user->hasPermissionTo('update movementassetaudits');
    }

    /**
     * Determine whether the movementAssetAudit can delete the model.
     */
    public function delete(User $user, MovementAssetAudit $model): bool
    {
        return $user->hasPermissionTo('delete movementassetaudits');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete movementassetaudits');
    }

    /**
     * Determine whether the movementAssetAudit can restore the model.
     */
    public function restore(User $user, MovementAssetAudit $model): bool
    {
        return false;
    }

    /**
     * Determine whether the movementAssetAudit can permanently delete the model.
     */
    public function forceDelete(User $user, MovementAssetAudit $model): bool
    {
        return false;
    }
}
