<?php

namespace App\Policies;

use App\Models\Bank;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BankPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the bank can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list banks');
    }

    /**
     * Determine whether the bank can view the model.
     */
    public function view(User $user, Bank $model): bool
    {
        return $user->hasPermissionTo('view banks');
    }

    /**
     * Determine whether the bank can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create banks');
    }

    /**
     * Determine whether the bank can update the model.
     */
    public function update(User $user, Bank $model): bool
    {
        return $user->hasPermissionTo('update banks');
    }

    /**
     * Determine whether the bank can delete the model.
     */
    public function delete(User $user, Bank $model): bool
    {
        return $user->hasPermissionTo('delete banks');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete banks');
    }

    /**
     * Determine whether the bank can restore the model.
     */
    public function restore(User $user, Bank $model): bool
    {
        return false;
    }

    /**
     * Determine whether the bank can permanently delete the model.
     */
    public function forceDelete(User $user, Bank $model): bool
    {
        return false;
    }
}
