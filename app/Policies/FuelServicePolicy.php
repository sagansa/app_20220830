<?php

namespace App\Policies;

use App\Models\User;
use App\Models\FuelService;
use Illuminate\Auth\Access\HandlesAuthorization;

class FuelServicePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the fuelService can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list fuelservices');
    }

    /**
     * Determine whether the fuelService can view the model.
     */
    public function view(User $user, FuelService $model): bool
    {
        return $user->hasPermissionTo('view fuelservices');
    }

    /**
     * Determine whether the fuelService can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create fuelservices');
    }

    /**
     * Determine whether the fuelService can update the model.
     */
    public function update(User $user, FuelService $model): bool
    {
        return $user->hasPermissionTo('update fuelservices');
    }

    /**
     * Determine whether the fuelService can delete the model.
     */
    public function delete(User $user, FuelService $model): bool
    {
        return $user->hasPermissionTo('delete fuelservices');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete fuelservices');
    }

    /**
     * Determine whether the fuelService can restore the model.
     */
    public function restore(User $user, FuelService $model): bool
    {
        return false;
    }

    /**
     * Determine whether the fuelService can permanently delete the model.
     */
    public function forceDelete(User $user, FuelService $model): bool
    {
        return false;
    }
}
