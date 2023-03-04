<?php

namespace App\Policies;

use App\Models\User;
use App\Models\DetailRequest;
use Illuminate\Auth\Access\HandlesAuthorization;

class DetailRequestPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the detailRequest can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list detailrequests');
    }

    /**
     * Determine whether the detailRequest can view the model.
     */
    public function view(User $user, DetailRequest $model): bool
    {
        return $user->hasPermissionTo('view detailrequests');
    }

    /**
     * Determine whether the detailRequest can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create detailrequests');
    }

    /**
     * Determine whether the detailRequest can update the model.
     */
    public function update(User $user, DetailRequest $model): bool
    {
        return $user->hasPermissionTo('update detailrequests');
    }

    /**
     * Determine whether the detailRequest can delete the model.
     */
    public function delete(User $user, DetailRequest $model): bool
    {
        return $user->hasPermissionTo('delete detailrequests');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete detailrequests');
    }

    /**
     * Determine whether the detailRequest can restore the model.
     */
    public function restore(User $user, DetailRequest $model): bool
    {
        return false;
    }

    /**
     * Determine whether the detailRequest can permanently delete the model.
     */
    public function forceDelete(User $user, DetailRequest $model): bool
    {
        return false;
    }
}
