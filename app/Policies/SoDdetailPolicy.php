<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SoDdetail;
use Illuminate\Auth\Access\HandlesAuthorization;

class SoDdetailPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the soDdetail can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list soddetails');
    }

    /**
     * Determine whether the soDdetail can view the model.
     */
    public function view(User $user, SoDdetail $model): bool
    {
        return $user->hasPermissionTo('view soddetails');
    }

    /**
     * Determine whether the soDdetail can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create soddetails');
    }

    /**
     * Determine whether the soDdetail can update the model.
     */
    public function update(User $user, SoDdetail $model): bool
    {
        return $user->hasPermissionTo('update soddetails');
    }

    /**
     * Determine whether the soDdetail can delete the model.
     */
    public function delete(User $user, SoDdetail $model): bool
    {
        return $user->hasPermissionTo('delete soddetails');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete soddetails');
    }

    /**
     * Determine whether the soDdetail can restore the model.
     */
    public function restore(User $user, SoDdetail $model): bool
    {
        return false;
    }

    /**
     * Determine whether the soDdetail can permanently delete the model.
     */
    public function forceDelete(User $user, SoDdetail $model): bool
    {
        return false;
    }
}
