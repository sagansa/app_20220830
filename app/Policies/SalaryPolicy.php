<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Salary;
use Illuminate\Auth\Access\HandlesAuthorization;

class SalaryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the salary can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list salaries');
    }

    /**
     * Determine whether the salary can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Salary  $model
     * @return mixed
     */
    public function view(User $user, Salary $model)
    {
        return $user->hasPermissionTo('view salaries');
    }

    /**
     * Determine whether the salary can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create salaries');
    }

    /**
     * Determine whether the salary can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Salary  $model
     * @return mixed
     */
    public function update(User $user, Salary $model)
    {
        return $user->hasPermissionTo('update salaries');
    }

    /**
     * Determine whether the salary can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Salary  $model
     * @return mixed
     */
    public function delete(User $user, Salary $model)
    {
        return $user->hasPermissionTo('delete salaries');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Salary  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete salaries');
    }

    /**
     * Determine whether the salary can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Salary  $model
     * @return mixed
     */
    public function restore(User $user, Salary $model)
    {
        return false;
    }

    /**
     * Determine whether the salary can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Salary  $model
     * @return mixed
     */
    public function forceDelete(User $user, Salary $model)
    {
        return false;
    }
}
