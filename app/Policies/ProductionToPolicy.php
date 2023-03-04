<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ProductionTo;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductionToPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the productionTo can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list productiontos');
    }

    /**
     * Determine whether the productionTo can view the model.
     */
    public function view(User $user, ProductionTo $model): bool
    {
        return $user->hasPermissionTo('view productiontos');
    }

    /**
     * Determine whether the productionTo can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create productiontos');
    }

    /**
     * Determine whether the productionTo can update the model.
     */
    public function update(User $user, ProductionTo $model): bool
    {
        return $user->hasPermissionTo('update productiontos');
    }

    /**
     * Determine whether the productionTo can delete the model.
     */
    public function delete(User $user, ProductionTo $model): bool
    {
        return $user->hasPermissionTo('delete productiontos');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete productiontos');
    }

    /**
     * Determine whether the productionTo can restore the model.
     */
    public function restore(User $user, ProductionTo $model): bool
    {
        return false;
    }

    /**
     * Determine whether the productionTo can permanently delete the model.
     */
    public function forceDelete(User $user, ProductionTo $model): bool
    {
        return false;
    }
}
