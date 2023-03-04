<?php

namespace App\Policies;

use App\Models\User;
use App\Models\StoreAsset;
use Illuminate\Auth\Access\HandlesAuthorization;

class StoreAssetPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the storeAsset can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list storeassets');
    }

    /**
     * Determine whether the storeAsset can view the model.
     */
    public function view(User $user, StoreAsset $model): bool
    {
        return $user->hasPermissionTo('view storeassets');
    }

    /**
     * Determine whether the storeAsset can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create storeassets');
    }

    /**
     * Determine whether the storeAsset can update the model.
     */
    public function update(User $user, StoreAsset $model): bool
    {
        return $user->hasPermissionTo('update storeassets');
    }

    /**
     * Determine whether the storeAsset can delete the model.
     */
    public function delete(User $user, StoreAsset $model): bool
    {
        return $user->hasPermissionTo('delete storeassets');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete storeassets');
    }

    /**
     * Determine whether the storeAsset can restore the model.
     */
    public function restore(User $user, StoreAsset $model): bool
    {
        return false;
    }

    /**
     * Determine whether the storeAsset can permanently delete the model.
     */
    public function forceDelete(User $user, StoreAsset $model): bool
    {
        return false;
    }
}
