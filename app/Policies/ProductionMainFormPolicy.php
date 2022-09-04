<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ProductionMainForm;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductionMainFormPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the productionMainForm can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list productionmainforms');
    }

    /**
     * Determine whether the productionMainForm can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ProductionMainForm  $model
     * @return mixed
     */
    public function view(User $user, ProductionMainForm $model)
    {
        return $user->hasPermissionTo('view productionmainforms');
    }

    /**
     * Determine whether the productionMainForm can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create productionmainforms');
    }

    /**
     * Determine whether the productionMainForm can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ProductionMainForm  $model
     * @return mixed
     */
    public function update(User $user, ProductionMainForm $model)
    {
        return $user->hasPermissionTo('update productionmainforms');
    }

    /**
     * Determine whether the productionMainForm can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ProductionMainForm  $model
     * @return mixed
     */
    public function delete(User $user, ProductionMainForm $model)
    {
        return $user->hasPermissionTo('delete productionmainforms');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ProductionMainForm  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete productionmainforms');
    }

    /**
     * Determine whether the productionMainForm can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ProductionMainForm  $model
     * @return mixed
     */
    public function restore(User $user, ProductionMainForm $model)
    {
        return false;
    }

    /**
     * Determine whether the productionMainForm can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ProductionMainForm  $model
     * @return mixed
     */
    public function forceDelete(User $user, ProductionMainForm $model)
    {
        return false;
    }
}
