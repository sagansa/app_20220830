<?php

namespace App\Policies;

use App\Models\User;
use App\Models\TransferStock;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransferStockPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the transferStock can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list transferstocks');
    }

    /**
     * Determine whether the transferStock can view the model.
     */
    public function view(User $user, TransferStock $model): bool
    {
        return $user->hasPermissionTo('view transferstocks');
    }

    /**
     * Determine whether the transferStock can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create transferstocks');
    }

    /**
     * Determine whether the transferStock can update the model.
     */
    public function update(User $user, TransferStock $model): bool
    {
        return $user->hasPermissionTo('update transferstocks');
    }

    /**
     * Determine whether the transferStock can delete the model.
     */
    public function delete(User $user, TransferStock $model): bool
    {
        return $user->hasPermissionTo('delete transferstocks');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete transferstocks');
    }

    /**
     * Determine whether the transferStock can restore the model.
     */
    public function restore(User $user, TransferStock $model): bool
    {
        return false;
    }

    /**
     * Determine whether the transferStock can permanently delete the model.
     */
    public function forceDelete(User $user, TransferStock $model): bool
    {
        return false;
    }
}
