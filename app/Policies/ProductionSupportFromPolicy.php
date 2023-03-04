<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ProductionSupportFrom;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductionSupportFromPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the productionSupportFrom can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list productionsupportfroms');
    }

    /**
     * Determine whether the productionSupportFrom can view the model.
     */
    public function view(User $user, ProductionSupportFrom $model): bool
    {
        return $user->hasPermissionTo('view productionsupportfroms');
    }

    /**
     * Determine whether the productionSupportFrom can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create productionsupportfroms');
    }

    /**
     * Determine whether the productionSupportFrom can update the model.
     */
    public function update(User $user, ProductionSupportFrom $model): bool
    {
        return $user->hasPermissionTo('update productionsupportfroms');
    }

    /**
     * Determine whether the productionSupportFrom can delete the model.
     */
    public function delete(User $user, ProductionSupportFrom $model): bool
    {
        return $user->hasPermissionTo('delete productionsupportfroms');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete productionsupportfroms');
    }

    /**
     * Determine whether the productionSupportFrom can restore the model.
     */
    public function restore(User $user, ProductionSupportFrom $model): bool
    {
        return false;
    }

    /**
     * Determine whether the productionSupportFrom can permanently delete the model.
     */
    public function forceDelete(User $user, ProductionSupportFrom $model): bool
    {
        return false;
    }
}
