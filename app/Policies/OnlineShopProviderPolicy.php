<?php

namespace App\Policies;

use App\Models\User;
use App\Models\OnlineShopProvider;
use Illuminate\Auth\Access\HandlesAuthorization;

class OnlineShopProviderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the onlineShopProvider can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list onlineshopproviders');
    }

    /**
     * Determine whether the onlineShopProvider can view the model.
     */
    public function view(User $user, OnlineShopProvider $model): bool
    {
        return $user->hasPermissionTo('view onlineshopproviders');
    }

    /**
     * Determine whether the onlineShopProvider can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create onlineshopproviders');
    }

    /**
     * Determine whether the onlineShopProvider can update the model.
     */
    public function update(User $user, OnlineShopProvider $model): bool
    {
        return $user->hasPermissionTo('update onlineshopproviders');
    }

    /**
     * Determine whether the onlineShopProvider can delete the model.
     */
    public function delete(User $user, OnlineShopProvider $model): bool
    {
        return $user->hasPermissionTo('delete onlineshopproviders');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete onlineshopproviders');
    }

    /**
     * Determine whether the onlineShopProvider can restore the model.
     */
    public function restore(User $user, OnlineShopProvider $model): bool
    {
        return false;
    }

    /**
     * Determine whether the onlineShopProvider can permanently delete the model.
     */
    public function forceDelete(User $user, OnlineShopProvider $model): bool
    {
        return false;
    }
}
