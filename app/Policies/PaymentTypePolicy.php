<?php

namespace App\Policies;

use App\Models\User;
use App\Models\PaymentType;
use Illuminate\Auth\Access\HandlesAuthorization;

class PaymentTypePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the paymentType can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list paymenttypes');
    }

    /**
     * Determine whether the paymentType can view the model.
     */
    public function view(User $user, PaymentType $model): bool
    {
        return $user->hasPermissionTo('view paymenttypes');
    }

    /**
     * Determine whether the paymentType can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create paymenttypes');
    }

    /**
     * Determine whether the paymentType can update the model.
     */
    public function update(User $user, PaymentType $model): bool
    {
        return $user->hasPermissionTo('update paymenttypes');
    }

    /**
     * Determine whether the paymentType can delete the model.
     */
    public function delete(User $user, PaymentType $model): bool
    {
        return $user->hasPermissionTo('delete paymenttypes');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete paymenttypes');
    }

    /**
     * Determine whether the paymentType can restore the model.
     */
    public function restore(User $user, PaymentType $model): bool
    {
        return false;
    }

    /**
     * Determine whether the paymentType can permanently delete the model.
     */
    public function forceDelete(User $user, PaymentType $model): bool
    {
        return false;
    }
}
