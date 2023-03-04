<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Store;
use Illuminate\Auth\Access\HandlesAuthorization;

class StorePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the store can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list stores');
    }

    /**
     * Determine whether the store can view the model.
     */
    public function view(User $user, Store $model): bool
    {
        return $user->hasPermissionTo('view stores');
    }

    /**
     * Determine whether the store can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create stores');
    }

    /**
     * Determine whether the store can update the model.
     */
    public function update(User $user, Store $model): bool
    {
        return $user->hasPermissionTo('update stores');
    }

    /**
     * Determine whether the store can delete the model.
     */
    public function delete(User $user, Store $model): bool
    {
        return $user->hasPermissionTo('delete stores');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete stores');
    }

    /**
     * Determine whether the store can restore the model.
     */
    public function restore(User $user, Store $model): bool
    {
        return false;
    }

    /**
     * Determine whether the store can permanently delete the model.
     */
    public function forceDelete(User $user, Store $model): bool
    {
        return false;
    }
}
