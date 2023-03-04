<?php

namespace App\Policies;

use App\Models\User;
use App\Models\DeliveryLocation;
use Illuminate\Auth\Access\HandlesAuthorization;

class DeliveryLocationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the deliveryLocation can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list deliverylocations');
    }

    /**
     * Determine whether the deliveryLocation can view the model.
     */
    public function view(User $user, DeliveryLocation $model): bool
    {
        return $user->hasPermissionTo('view deliverylocations');
    }

    /**
     * Determine whether the deliveryLocation can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create deliverylocations');
    }

    /**
     * Determine whether the deliveryLocation can update the model.
     */
    public function update(User $user, DeliveryLocation $model): bool
    {
        return $user->hasPermissionTo('update deliverylocations');
    }

    /**
     * Determine whether the deliveryLocation can delete the model.
     */
    public function delete(User $user, DeliveryLocation $model): bool
    {
        return $user->hasPermissionTo('delete deliverylocations');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete deliverylocations');
    }

    /**
     * Determine whether the deliveryLocation can restore the model.
     */
    public function restore(User $user, DeliveryLocation $model): bool
    {
        return false;
    }

    /**
     * Determine whether the deliveryLocation can permanently delete the model.
     */
    public function forceDelete(User $user, DeliveryLocation $model): bool
    {
        return false;
    }
}
