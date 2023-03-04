<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UtilityBill;
use Illuminate\Auth\Access\HandlesAuthorization;

class UtilityBillPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the utilityBill can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list utilitybills');
    }

    /**
     * Determine whether the utilityBill can view the model.
     */
    public function view(User $user, UtilityBill $model): bool
    {
        return $user->hasPermissionTo('view utilitybills');
    }

    /**
     * Determine whether the utilityBill can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create utilitybills');
    }

    /**
     * Determine whether the utilityBill can update the model.
     */
    public function update(User $user, UtilityBill $model): bool
    {
        return $user->hasPermissionTo('update utilitybills');
    }

    /**
     * Determine whether the utilityBill can delete the model.
     */
    public function delete(User $user, UtilityBill $model): bool
    {
        return $user->hasPermissionTo('delete utilitybills');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete utilitybills');
    }

    /**
     * Determine whether the utilityBill can restore the model.
     */
    public function restore(User $user, UtilityBill $model): bool
    {
        return false;
    }

    /**
     * Determine whether the utilityBill can permanently delete the model.
     */
    public function forceDelete(User $user, UtilityBill $model): bool
    {
        return false;
    }
}
