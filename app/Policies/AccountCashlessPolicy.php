<?php

namespace App\Policies;

use App\Models\User;
use App\Models\AccountCashless;
use Illuminate\Auth\Access\HandlesAuthorization;

class AccountCashlessPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the accountCashless can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list accountcashlesses');
    }

    /**
     * Determine whether the accountCashless can view the model.
     */
    public function view(User $user, AccountCashless $model): bool
    {
        return $user->hasPermissionTo('view accountcashlesses');
    }

    /**
     * Determine whether the accountCashless can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create accountcashlesses');
    }

    /**
     * Determine whether the accountCashless can update the model.
     */
    public function update(User $user, AccountCashless $model): bool
    {
        return $user->hasPermissionTo('update accountcashlesses');
    }

    /**
     * Determine whether the accountCashless can delete the model.
     */
    public function delete(User $user, AccountCashless $model): bool
    {
        return $user->hasPermissionTo('delete accountcashlesses');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete accountcashlesses');
    }

    /**
     * Determine whether the accountCashless can restore the model.
     */
    public function restore(User $user, AccountCashless $model): bool
    {
        return false;
    }

    /**
     * Determine whether the accountCashless can permanently delete the model.
     */
    public function forceDelete(User $user, AccountCashless $model): bool
    {
        return false;
    }
}
