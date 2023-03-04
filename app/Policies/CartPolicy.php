<?php

namespace App\Policies;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CartPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the cart can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list carts');
    }

    /**
     * Determine whether the cart can view the model.
     */
    public function view(User $user, Cart $model): bool
    {
        return $user->hasPermissionTo('view carts');
    }

    /**
     * Determine whether the cart can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create carts');
    }

    /**
     * Determine whether the cart can update the model.
     */
    public function update(User $user, Cart $model): bool
    {
        return $user->hasPermissionTo('update carts');
    }

    /**
     * Determine whether the cart can delete the model.
     */
    public function delete(User $user, Cart $model): bool
    {
        return $user->hasPermissionTo('delete carts');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete carts');
    }

    /**
     * Determine whether the cart can restore the model.
     */
    public function restore(User $user, Cart $model): bool
    {
        return false;
    }

    /**
     * Determine whether the cart can permanently delete the model.
     */
    public function forceDelete(User $user, Cart $model): bool
    {
        return false;
    }
}
