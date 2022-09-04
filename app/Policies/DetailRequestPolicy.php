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
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list detailrequests');
    }

    /**
     * Determine whether the detailRequest can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DetailRequest  $model
     * @return mixed
     */
    public function view(User $user, DetailRequest $model)
    {
        return $user->hasPermissionTo('view detailrequests');
    }

    /**
     * Determine whether the detailRequest can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create detailrequests');
    }

    /**
     * Determine whether the detailRequest can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DetailRequest  $model
     * @return mixed
     */
    public function update(User $user, DetailRequest $model)
    {
        return $user->hasPermissionTo('update detailrequests');
    }

    /**
     * Determine whether the detailRequest can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DetailRequest  $model
     * @return mixed
     */
    public function delete(User $user, DetailRequest $model)
    {
        return $user->hasPermissionTo('delete detailrequests');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DetailRequest  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete detailrequests');
    }

    /**
     * Determine whether the detailRequest can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DetailRequest  $model
     * @return mixed
     */
    public function restore(User $user, DetailRequest $model)
    {
        return false;
    }

    /**
     * Determine whether the detailRequest can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DetailRequest  $model
     * @return mixed
     */
    public function forceDelete(User $user, DetailRequest $model)
    {
        return false;
    }
}
