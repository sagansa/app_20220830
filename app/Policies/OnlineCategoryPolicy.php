<?php

namespace App\Policies;

use App\Models\User;
use App\Models\OnlineCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class OnlineCategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the onlineCategory can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list onlinecategories');
    }

    /**
     * Determine whether the onlineCategory can view the model.
     */
    public function view(User $user, OnlineCategory $model): bool
    {
        return $user->hasPermissionTo('view onlinecategories');
    }

    /**
     * Determine whether the onlineCategory can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create onlinecategories');
    }

    /**
     * Determine whether the onlineCategory can update the model.
     */
    public function update(User $user, OnlineCategory $model): bool
    {
        return $user->hasPermissionTo('update onlinecategories');
    }

    /**
     * Determine whether the onlineCategory can delete the model.
     */
    public function delete(User $user, OnlineCategory $model): bool
    {
        return $user->hasPermissionTo('delete onlinecategories');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete onlinecategories');
    }

    /**
     * Determine whether the onlineCategory can restore the model.
     */
    public function restore(User $user, OnlineCategory $model): bool
    {
        return false;
    }

    /**
     * Determine whether the onlineCategory can permanently delete the model.
     */
    public function forceDelete(User $user, OnlineCategory $model): bool
    {
        return false;
    }
}
