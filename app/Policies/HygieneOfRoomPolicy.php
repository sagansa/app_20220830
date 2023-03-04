<?php

namespace App\Policies;

use App\Models\User;
use App\Models\HygieneOfRoom;
use Illuminate\Auth\Access\HandlesAuthorization;

class HygieneOfRoomPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the hygieneOfRoom can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list hygieneofrooms');
    }

    /**
     * Determine whether the hygieneOfRoom can view the model.
     */
    public function view(User $user, HygieneOfRoom $model): bool
    {
        return $user->hasPermissionTo('view hygieneofrooms');
    }

    /**
     * Determine whether the hygieneOfRoom can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create hygieneofrooms');
    }

    /**
     * Determine whether the hygieneOfRoom can update the model.
     */
    public function update(User $user, HygieneOfRoom $model): bool
    {
        return $user->hasPermissionTo('update hygieneofrooms');
    }

    /**
     * Determine whether the hygieneOfRoom can delete the model.
     */
    public function delete(User $user, HygieneOfRoom $model): bool
    {
        return $user->hasPermissionTo('delete hygieneofrooms');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete hygieneofrooms');
    }

    /**
     * Determine whether the hygieneOfRoom can restore the model.
     */
    public function restore(User $user, HygieneOfRoom $model): bool
    {
        return false;
    }

    /**
     * Determine whether the hygieneOfRoom can permanently delete the model.
     */
    public function forceDelete(User $user, HygieneOfRoom $model): bool
    {
        return false;
    }
}
