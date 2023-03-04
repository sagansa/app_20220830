<?php

namespace App\Policies;

use App\Models\User;
use App\Models\TransferToAccount;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransferToAccountPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the transferToAccount can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list transfertoaccounts');
    }

    /**
     * Determine whether the transferToAccount can view the model.
     */
    public function view(User $user, TransferToAccount $model): bool
    {
        return $user->hasPermissionTo('view transfertoaccounts');
    }

    /**
     * Determine whether the transferToAccount can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create transfertoaccounts');
    }

    /**
     * Determine whether the transferToAccount can update the model.
     */
    public function update(User $user, TransferToAccount $model): bool
    {
        return $user->hasPermissionTo('update transfertoaccounts');
    }

    /**
     * Determine whether the transferToAccount can delete the model.
     */
    public function delete(User $user, TransferToAccount $model): bool
    {
        return $user->hasPermissionTo('delete transfertoaccounts');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete transfertoaccounts');
    }

    /**
     * Determine whether the transferToAccount can restore the model.
     */
    public function restore(User $user, TransferToAccount $model): bool
    {
        return false;
    }

    /**
     * Determine whether the transferToAccount can permanently delete the model.
     */
    public function forceDelete(User $user, TransferToAccount $model): bool
    {
        return false;
    }
}
