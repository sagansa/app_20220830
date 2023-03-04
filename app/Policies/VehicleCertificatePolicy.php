<?php

namespace App\Policies;

use App\Models\User;
use App\Models\VehicleCertificate;
use Illuminate\Auth\Access\HandlesAuthorization;

class VehicleCertificatePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the vehicleCertificate can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list vehiclecertificates');
    }

    /**
     * Determine whether the vehicleCertificate can view the model.
     */
    public function view(User $user, VehicleCertificate $model): bool
    {
        return $user->hasPermissionTo('view vehiclecertificates');
    }

    /**
     * Determine whether the vehicleCertificate can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create vehiclecertificates');
    }

    /**
     * Determine whether the vehicleCertificate can update the model.
     */
    public function update(User $user, VehicleCertificate $model): bool
    {
        return $user->hasPermissionTo('update vehiclecertificates');
    }

    /**
     * Determine whether the vehicleCertificate can delete the model.
     */
    public function delete(User $user, VehicleCertificate $model): bool
    {
        return $user->hasPermissionTo('delete vehiclecertificates');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete vehiclecertificates');
    }

    /**
     * Determine whether the vehicleCertificate can restore the model.
     */
    public function restore(User $user, VehicleCertificate $model): bool
    {
        return false;
    }

    /**
     * Determine whether the vehicleCertificate can permanently delete the model.
     */
    public function forceDelete(User $user, VehicleCertificate $model): bool
    {
        return false;
    }
}
