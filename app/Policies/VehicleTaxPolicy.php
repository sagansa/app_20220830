<?php

namespace App\Policies;

use App\Models\User;
use App\Models\VehicleTax;
use Illuminate\Auth\Access\HandlesAuthorization;

class VehicleTaxPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the vehicleTax can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list vehicletaxes');
    }

    /**
     * Determine whether the vehicleTax can view the model.
     */
    public function view(User $user, VehicleTax $model): bool
    {
        return $user->hasPermissionTo('view vehicletaxes');
    }

    /**
     * Determine whether the vehicleTax can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create vehicletaxes');
    }

    /**
     * Determine whether the vehicleTax can update the model.
     */
    public function update(User $user, VehicleTax $model): bool
    {
        return $user->hasPermissionTo('update vehicletaxes');
    }

    /**
     * Determine whether the vehicleTax can delete the model.
     */
    public function delete(User $user, VehicleTax $model): bool
    {
        return $user->hasPermissionTo('delete vehicletaxes');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete vehicletaxes');
    }

    /**
     * Determine whether the vehicleTax can restore the model.
     */
    public function restore(User $user, VehicleTax $model): bool
    {
        return false;
    }

    /**
     * Determine whether the vehicleTax can permanently delete the model.
     */
    public function forceDelete(User $user, VehicleTax $model): bool
    {
        return false;
    }
}
