<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ProductGroup;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductGroupPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the productGroup can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list productgroups');
    }

    /**
     * Determine whether the productGroup can view the model.
     */
    public function view(User $user, ProductGroup $model): bool
    {
        return $user->hasPermissionTo('view productgroups');
    }

    /**
     * Determine whether the productGroup can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create productgroups');
    }

    /**
     * Determine whether the productGroup can update the model.
     */
    public function update(User $user, ProductGroup $model): bool
    {
        return $user->hasPermissionTo('update productgroups');
    }

    /**
     * Determine whether the productGroup can delete the model.
     */
    public function delete(User $user, ProductGroup $model): bool
    {
        return $user->hasPermissionTo('delete productgroups');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete productgroups');
    }

    /**
     * Determine whether the productGroup can restore the model.
     */
    public function restore(User $user, ProductGroup $model): bool
    {
        return false;
    }

    /**
     * Determine whether the productGroup can permanently delete the model.
     */
    public function forceDelete(User $user, ProductGroup $model): bool
    {
        return false;
    }
}
