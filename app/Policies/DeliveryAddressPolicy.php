<?php

namespace App\Policies;

use App\Models\User;
use App\Models\DeliveryAddress;
use Illuminate\Auth\Access\HandlesAuthorization;

class DeliveryAddressPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the deliveryAddress can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list deliveryaddresses');
    }

    /**
     * Determine whether the deliveryAddress can view the model.
     */
    public function view(User $user, DeliveryAddress $model): bool
    {
        return $user->hasPermissionTo('view deliveryaddresses');
    }

    /**
     * Determine whether the deliveryAddress can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create deliveryaddresses');
    }

    /**
     * Determine whether the deliveryAddress can update the model.
     */
    public function update(User $user, DeliveryAddress $model): bool
    {
        return $user->hasPermissionTo('update deliveryaddresses');
    }

    /**
     * Determine whether the deliveryAddress can delete the model.
     */
    public function delete(User $user, DeliveryAddress $model): bool
    {
        return $user->hasPermissionTo('delete deliveryaddresses');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete deliveryaddresses');
    }

    /**
     * Determine whether the deliveryAddress can restore the model.
     */
    public function restore(User $user, DeliveryAddress $model): bool
    {
        return false;
    }

    /**
     * Determine whether the deliveryAddress can permanently delete the model.
     */
    public function forceDelete(User $user, DeliveryAddress $model): bool
    {
        return false;
    }
}
