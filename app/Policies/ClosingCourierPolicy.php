<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ClosingCourier;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClosingCourierPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the closingCourier can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list closingcouriers');
    }

    /**
     * Determine whether the closingCourier can view the model.
     */
    public function view(User $user, ClosingCourier $model): bool
    {
        return $user->hasPermissionTo('view closingcouriers');
    }

    /**
     * Determine whether the closingCourier can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create closingcouriers');
    }

    /**
     * Determine whether the closingCourier can update the model.
     */
    public function update(User $user, ClosingCourier $model): bool
    {
        return $user->hasPermissionTo('update closingcouriers');
    }

    /**
     * Determine whether the closingCourier can delete the model.
     */
    public function delete(User $user, ClosingCourier $model): bool
    {
        return $user->hasPermissionTo('delete closingcouriers');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete closingcouriers');
    }

    /**
     * Determine whether the closingCourier can restore the model.
     */
    public function restore(User $user, ClosingCourier $model): bool
    {
        return false;
    }

    /**
     * Determine whether the closingCourier can permanently delete the model.
     */
    public function forceDelete(User $user, ClosingCourier $model): bool
    {
        return false;
    }
}
