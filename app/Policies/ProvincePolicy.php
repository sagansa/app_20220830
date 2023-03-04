<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Province;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProvincePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the province can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list provinces');
    }

    /**
     * Determine whether the province can view the model.
     */
    public function view(User $user, Province $model): bool
    {
        return $user->hasPermissionTo('view provinces');
    }

    /**
     * Determine whether the province can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create provinces');
    }

    /**
     * Determine whether the province can update the model.
     */
    public function update(User $user, Province $model): bool
    {
        return $user->hasPermissionTo('update provinces');
    }

    /**
     * Determine whether the province can delete the model.
     */
    public function delete(User $user, Province $model): bool
    {
        return $user->hasPermissionTo('delete provinces');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete provinces');
    }

    /**
     * Determine whether the province can restore the model.
     */
    public function restore(User $user, Province $model): bool
    {
        return false;
    }

    /**
     * Determine whether the province can permanently delete the model.
     */
    public function forceDelete(User $user, Province $model): bool
    {
        return false;
    }
}
