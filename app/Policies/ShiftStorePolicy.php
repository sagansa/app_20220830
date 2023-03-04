<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ShiftStore;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShiftStorePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the shiftStore can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list shiftstores');
    }

    /**
     * Determine whether the shiftStore can view the model.
     */
    public function view(User $user, ShiftStore $model): bool
    {
        return $user->hasPermissionTo('view shiftstores');
    }

    /**
     * Determine whether the shiftStore can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create shiftstores');
    }

    /**
     * Determine whether the shiftStore can update the model.
     */
    public function update(User $user, ShiftStore $model): bool
    {
        return $user->hasPermissionTo('update shiftstores');
    }

    /**
     * Determine whether the shiftStore can delete the model.
     */
    public function delete(User $user, ShiftStore $model): bool
    {
        return $user->hasPermissionTo('delete shiftstores');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete shiftstores');
    }

    /**
     * Determine whether the shiftStore can restore the model.
     */
    public function restore(User $user, ShiftStore $model): bool
    {
        return false;
    }

    /**
     * Determine whether the shiftStore can permanently delete the model.
     */
    public function forceDelete(User $user, ShiftStore $model): bool
    {
        return false;
    }
}
