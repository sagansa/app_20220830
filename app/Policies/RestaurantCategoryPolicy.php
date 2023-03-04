<?php

namespace App\Policies;

use App\Models\User;
use App\Models\RestaurantCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class RestaurantCategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the restaurantCategory can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list restaurantcategories');
    }

    /**
     * Determine whether the restaurantCategory can view the model.
     */
    public function view(User $user, RestaurantCategory $model): bool
    {
        return $user->hasPermissionTo('view restaurantcategories');
    }

    /**
     * Determine whether the restaurantCategory can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create restaurantcategories');
    }

    /**
     * Determine whether the restaurantCategory can update the model.
     */
    public function update(User $user, RestaurantCategory $model): bool
    {
        return $user->hasPermissionTo('update restaurantcategories');
    }

    /**
     * Determine whether the restaurantCategory can delete the model.
     */
    public function delete(User $user, RestaurantCategory $model): bool
    {
        return $user->hasPermissionTo('delete restaurantcategories');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete restaurantcategories');
    }

    /**
     * Determine whether the restaurantCategory can restore the model.
     */
    public function restore(User $user, RestaurantCategory $model): bool
    {
        return false;
    }

    /**
     * Determine whether the restaurantCategory can permanently delete the model.
     */
    public function forceDelete(User $user, RestaurantCategory $model): bool
    {
        return false;
    }
}
