<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ProductionFrom;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductionFromPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the productionFrom can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list productionfroms');
    }

    /**
     * Determine whether the productionFrom can view the model.
     */
    public function view(User $user, ProductionFrom $model): bool
    {
        return $user->hasPermissionTo('view productionfroms');
    }

    /**
     * Determine whether the productionFrom can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create productionfroms');
    }

    /**
     * Determine whether the productionFrom can update the model.
     */
    public function update(User $user, ProductionFrom $model): bool
    {
        return $user->hasPermissionTo('update productionfroms');
    }

    /**
     * Determine whether the productionFrom can delete the model.
     */
    public function delete(User $user, ProductionFrom $model): bool
    {
        return $user->hasPermissionTo('delete productionfroms');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete productionfroms');
    }

    /**
     * Determine whether the productionFrom can restore the model.
     */
    public function restore(User $user, ProductionFrom $model): bool
    {
        return false;
    }

    /**
     * Determine whether the productionFrom can permanently delete the model.
     */
    public function forceDelete(User $user, ProductionFrom $model): bool
    {
        return false;
    }
}
