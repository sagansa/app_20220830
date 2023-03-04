<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ProductionMainFrom;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductionMainFromPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the productionMainFrom can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list productionmainfroms');
    }

    /**
     * Determine whether the productionMainFrom can view the model.
     */
    public function view(User $user, ProductionMainFrom $model): bool
    {
        return $user->hasPermissionTo('view productionmainfroms');
    }

    /**
     * Determine whether the productionMainFrom can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create productionmainfroms');
    }

    /**
     * Determine whether the productionMainFrom can update the model.
     */
    public function update(User $user, ProductionMainFrom $model): bool
    {
        return $user->hasPermissionTo('update productionmainfroms');
    }

    /**
     * Determine whether the productionMainFrom can delete the model.
     */
    public function delete(User $user, ProductionMainFrom $model): bool
    {
        return $user->hasPermissionTo('delete productionmainfroms');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete productionmainfroms');
    }

    /**
     * Determine whether the productionMainFrom can restore the model.
     */
    public function restore(User $user, ProductionMainFrom $model): bool
    {
        return false;
    }

    /**
     * Determine whether the productionMainFrom can permanently delete the model.
     */
    public function forceDelete(User $user, ProductionMainFrom $model): bool
    {
        return false;
    }
}
