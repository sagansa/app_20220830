<?php

namespace App\Policies;

use App\Models\User;
use App\Models\EProduct;
use Illuminate\Auth\Access\HandlesAuthorization;

class EProductPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the eProduct can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list eproducts');
    }

    /**
     * Determine whether the eProduct can view the model.
     */
    public function view(User $user, EProduct $model): bool
    {
        return $user->hasPermissionTo('view eproducts');
    }

    /**
     * Determine whether the eProduct can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create eproducts');
    }

    /**
     * Determine whether the eProduct can update the model.
     */
    public function update(User $user, EProduct $model): bool
    {
        return $user->hasPermissionTo('update eproducts');
    }

    /**
     * Determine whether the eProduct can delete the model.
     */
    public function delete(User $user, EProduct $model): bool
    {
        return $user->hasPermissionTo('delete eproducts');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete eproducts');
    }

    /**
     * Determine whether the eProduct can restore the model.
     */
    public function restore(User $user, EProduct $model): bool
    {
        return false;
    }

    /**
     * Determine whether the eProduct can permanently delete the model.
     */
    public function forceDelete(User $user, EProduct $model): bool
    {
        return false;
    }
}
