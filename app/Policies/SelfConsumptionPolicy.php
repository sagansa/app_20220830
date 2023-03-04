<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SelfConsumption;
use Illuminate\Auth\Access\HandlesAuthorization;

class SelfConsumptionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the selfConsumption can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list selfconsumptions');
    }

    /**
     * Determine whether the selfConsumption can view the model.
     */
    public function view(User $user, SelfConsumption $model): bool
    {
        return $user->hasPermissionTo('view selfconsumptions');
    }

    /**
     * Determine whether the selfConsumption can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create selfconsumptions');
    }

    /**
     * Determine whether the selfConsumption can update the model.
     */
    public function update(User $user, SelfConsumption $model): bool
    {
        return $user->hasPermissionTo('update selfconsumptions');
    }

    /**
     * Determine whether the selfConsumption can delete the model.
     */
    public function delete(User $user, SelfConsumption $model): bool
    {
        return $user->hasPermissionTo('delete selfconsumptions');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete selfconsumptions');
    }

    /**
     * Determine whether the selfConsumption can restore the model.
     */
    public function restore(User $user, SelfConsumption $model): bool
    {
        return false;
    }

    /**
     * Determine whether the selfConsumption can permanently delete the model.
     */
    public function forceDelete(User $user, SelfConsumption $model): bool
    {
        return false;
    }
}
