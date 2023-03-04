<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ContractLocation;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContractLocationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the contractLocation can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list contractlocations');
    }

    /**
     * Determine whether the contractLocation can view the model.
     */
    public function view(User $user, ContractLocation $model): bool
    {
        return $user->hasPermissionTo('view contractlocations');
    }

    /**
     * Determine whether the contractLocation can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create contractlocations');
    }

    /**
     * Determine whether the contractLocation can update the model.
     */
    public function update(User $user, ContractLocation $model): bool
    {
        return $user->hasPermissionTo('update contractlocations');
    }

    /**
     * Determine whether the contractLocation can delete the model.
     */
    public function delete(User $user, ContractLocation $model): bool
    {
        return $user->hasPermissionTo('delete contractlocations');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete contractlocations');
    }

    /**
     * Determine whether the contractLocation can restore the model.
     */
    public function restore(User $user, ContractLocation $model): bool
    {
        return false;
    }

    /**
     * Determine whether the contractLocation can permanently delete the model.
     */
    public function forceDelete(User $user, ContractLocation $model): bool
    {
        return false;
    }
}
