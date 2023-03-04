<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ContractEmployee;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContractEmployeePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the contractEmployee can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list contractemployees');
    }

    /**
     * Determine whether the contractEmployee can view the model.
     */
    public function view(User $user, ContractEmployee $model): bool
    {
        return $user->hasPermissionTo('view contractemployees');
    }

    /**
     * Determine whether the contractEmployee can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create contractemployees');
    }

    /**
     * Determine whether the contractEmployee can update the model.
     */
    public function update(User $user, ContractEmployee $model): bool
    {
        return $user->hasPermissionTo('update contractemployees');
    }

    /**
     * Determine whether the contractEmployee can delete the model.
     */
    public function delete(User $user, ContractEmployee $model): bool
    {
        return $user->hasPermissionTo('delete contractemployees');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete contractemployees');
    }

    /**
     * Determine whether the contractEmployee can restore the model.
     */
    public function restore(User $user, ContractEmployee $model): bool
    {
        return false;
    }

    /**
     * Determine whether the contractEmployee can permanently delete the model.
     */
    public function forceDelete(User $user, ContractEmployee $model): bool
    {
        return false;
    }
}
