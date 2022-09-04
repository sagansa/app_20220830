<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ProductionMainFrom;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductionMainFromPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the productionMainFrom can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list productionmainfroms');
    }

    /**
     * Determine whether the productionMainFrom can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ProductionMainFrom  $model
     * @return mixed
     */
    public function view(User $user, ProductionMainFrom $model)
    {
        return $user->hasPermissionTo('view productionmainfroms');
    }

    /**
     * Determine whether the productionMainFrom can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create productionmainfroms');
    }

    /**
     * Determine whether the productionMainFrom can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ProductionMainFrom  $model
     * @return mixed
     */
    public function update(User $user, ProductionMainFrom $model)
    {
        return $user->hasPermissionTo('update productionmainfroms');
    }

    /**
     * Determine whether the productionMainFrom can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ProductionMainFrom  $model
     * @return mixed
     */
    public function delete(User $user, ProductionMainFrom $model)
    {
        return $user->hasPermissionTo('delete productionmainfroms');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ProductionMainFrom  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete productionmainfroms');
    }

    /**
     * Determine whether the productionMainFrom can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ProductionMainFrom  $model
     * @return mixed
     */
    public function restore(User $user, ProductionMainFrom $model)
    {
        return false;
    }

    /**
     * Determine whether the productionMainFrom can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ProductionMainFrom  $model
     * @return mixed
     */
    public function forceDelete(User $user, ProductionMainFrom $model)
    {
        return false;
    }
}
