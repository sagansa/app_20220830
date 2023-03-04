<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Hygiene;
use Illuminate\Auth\Access\HandlesAuthorization;

class HygienePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the hygiene can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list hygienes');
    }

    /**
     * Determine whether the hygiene can view the model.
     */
    public function view(User $user, Hygiene $model): bool
    {
        return $user->hasPermissionTo('view hygienes');
    }

    /**
     * Determine whether the hygiene can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create hygienes');
    }

    /**
     * Determine whether the hygiene can update the model.
     */
    public function update(User $user, Hygiene $model): bool
    {
        return $user->hasPermissionTo('update hygienes');
    }

    /**
     * Determine whether the hygiene can delete the model.
     */
    public function delete(User $user, Hygiene $model): bool
    {
        return $user->hasPermissionTo('delete hygienes');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete hygienes');
    }

    /**
     * Determine whether the hygiene can restore the model.
     */
    public function restore(User $user, Hygiene $model): bool
    {
        return false;
    }

    /**
     * Determine whether the hygiene can permanently delete the model.
     */
    public function forceDelete(User $user, Hygiene $model): bool
    {
        return false;
    }
}
