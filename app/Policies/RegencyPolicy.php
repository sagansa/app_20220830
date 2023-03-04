<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Regency;
use Illuminate\Auth\Access\HandlesAuthorization;

class RegencyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the regency can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list regencies');
    }

    /**
     * Determine whether the regency can view the model.
     */
    public function view(User $user, Regency $model): bool
    {
        return $user->hasPermissionTo('view regencies');
    }

    /**
     * Determine whether the regency can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create regencies');
    }

    /**
     * Determine whether the regency can update the model.
     */
    public function update(User $user, Regency $model): bool
    {
        return $user->hasPermissionTo('update regencies');
    }

    /**
     * Determine whether the regency can delete the model.
     */
    public function delete(User $user, Regency $model): bool
    {
        return $user->hasPermissionTo('delete regencies');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete regencies');
    }

    /**
     * Determine whether the regency can restore the model.
     */
    public function restore(User $user, Regency $model): bool
    {
        return false;
    }

    /**
     * Determine whether the regency can permanently delete the model.
     */
    public function forceDelete(User $user, Regency $model): bool
    {
        return false;
    }
}
