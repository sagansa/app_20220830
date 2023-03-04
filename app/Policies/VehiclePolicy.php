<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Auth\Access\HandlesAuthorization;

class VehiclePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the vehicle can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list vehicles');
    }

    /**
     * Determine whether the vehicle can view the model.
     */
    public function view(User $user, Vehicle $model): bool
    {
        return $user->hasPermissionTo('view vehicles');
    }

    /**
     * Determine whether the vehicle can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create vehicles');
    }

    /**
     * Determine whether the vehicle can update the model.
     */
    public function update(User $user, Vehicle $model): bool
    {
        return $user->hasPermissionTo('update vehicles');
    }

    /**
     * Determine whether the vehicle can delete the model.
     */
    public function delete(User $user, Vehicle $model): bool
    {
        return $user->hasPermissionTo('delete vehicles');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete vehicles');
    }

    /**
     * Determine whether the vehicle can restore the model.
     */
    public function restore(User $user, Vehicle $model): bool
    {
        return false;
    }

    /**
     * Determine whether the vehicle can permanently delete the model.
     */
    public function forceDelete(User $user, Vehicle $model): bool
    {
        return false;
    }
}
