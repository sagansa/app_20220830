<?php

namespace App\Policies;

use App\Models\User;
use App\Models\EProduct;
use Illuminate\Auth\Access\HandlesAuthorization;

class EProductPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the eProduct can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list eproducts');
    }

    /**
     * Determine whether the eProduct can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\EProduct  $model
     * @return mixed
     */
    public function view(User $user, EProduct $model)
    {
        return $user->hasPermissionTo('view eproducts');
    }

    /**
     * Determine whether the eProduct can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create eproducts');
    }

    /**
     * Determine whether the eProduct can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\EProduct  $model
     * @return mixed
     */
    public function update(User $user, EProduct $model)
    {
        return $user->hasPermissionTo('update eproducts');
    }

    /**
     * Determine whether the eProduct can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\EProduct  $model
     * @return mixed
     */
    public function delete(User $user, EProduct $model)
    {
        return $user->hasPermissionTo('delete eproducts');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\EProduct  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete eproducts');
    }

    /**
     * Determine whether the eProduct can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\EProduct  $model
     * @return mixed
     */
    public function restore(User $user, EProduct $model)
    {
        return false;
    }

    /**
     * Determine whether the eProduct can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\EProduct  $model
     * @return mixed
     */
    public function forceDelete(User $user, EProduct $model)
    {
        return false;
    }
}
