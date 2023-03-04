<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Refund;
use Illuminate\Auth\Access\HandlesAuthorization;

class RefundPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the refund can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list refunds');
    }

    /**
     * Determine whether the refund can view the model.
     */
    public function view(User $user, Refund $model): bool
    {
        return $user->hasPermissionTo('view refunds');
    }

    /**
     * Determine whether the refund can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create refunds');
    }

    /**
     * Determine whether the refund can update the model.
     */
    public function update(User $user, Refund $model): bool
    {
        return $user->hasPermissionTo('update refunds');
    }

    /**
     * Determine whether the refund can delete the model.
     */
    public function delete(User $user, Refund $model): bool
    {
        return $user->hasPermissionTo('delete refunds');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete refunds');
    }

    /**
     * Determine whether the refund can restore the model.
     */
    public function restore(User $user, Refund $model): bool
    {
        return false;
    }

    /**
     * Determine whether the refund can permanently delete the model.
     */
    public function forceDelete(User $user, Refund $model): bool
    {
        return false;
    }
}
