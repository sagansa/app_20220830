<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ProductionSupportFrom;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductionSupportFromPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the productionSupportFrom can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list productionsupportfroms');
    }

    /**
     * Determine whether the productionSupportFrom can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ProductionSupportFrom  $model
     * @return mixed
     */
    public function view(User $user, ProductionSupportFrom $model)
    {
        return $user->hasPermissionTo('view productionsupportfroms');
    }

    /**
     * Determine whether the productionSupportFrom can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create productionsupportfroms');
    }

    /**
     * Determine whether the productionSupportFrom can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ProductionSupportFrom  $model
     * @return mixed
     */
    public function update(User $user, ProductionSupportFrom $model)
    {
        return $user->hasPermissionTo('update productionsupportfroms');
    }

    /**
     * Determine whether the productionSupportFrom can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ProductionSupportFrom  $model
     * @return mixed
     */
    public function delete(User $user, ProductionSupportFrom $model)
    {
        return $user->hasPermissionTo('delete productionsupportfroms');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ProductionSupportFrom  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete productionsupportfroms');
    }

    /**
     * Determine whether the productionSupportFrom can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ProductionSupportFrom  $model
     * @return mixed
     */
    public function restore(User $user, ProductionSupportFrom $model)
    {
        return false;
    }

    /**
     * Determine whether the productionSupportFrom can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ProductionSupportFrom  $model
     * @return mixed
     */
    public function forceDelete(User $user, ProductionSupportFrom $model)
    {
        return false;
    }
}
