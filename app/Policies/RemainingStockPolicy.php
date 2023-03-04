<?php

namespace App\Policies;

use App\Models\User;
use App\Models\RemainingStock;
use Illuminate\Auth\Access\HandlesAuthorization;

class RemainingStockPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the remainingStock can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list remainingstocks');
    }

    /**
     * Determine whether the remainingStock can view the model.
     */
    public function view(User $user, RemainingStock $model): bool
    {
        return $user->hasPermissionTo('view remainingstocks');
    }

    /**
     * Determine whether the remainingStock can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create remainingstocks');
    }

    /**
     * Determine whether the remainingStock can update the model.
     */
    public function update(User $user, RemainingStock $model): bool
    {
        return $user->hasPermissionTo('update remainingstocks');
    }

    /**
     * Determine whether the remainingStock can delete the model.
     */
    public function delete(User $user, RemainingStock $model): bool
    {
        return $user->hasPermissionTo('delete remainingstocks');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete remainingstocks');
    }

    /**
     * Determine whether the remainingStock can restore the model.
     */
    public function restore(User $user, RemainingStock $model): bool
    {
        return false;
    }

    /**
     * Determine whether the remainingStock can permanently delete the model.
     */
    public function forceDelete(User $user, RemainingStock $model): bool
    {
        return false;
    }
}
