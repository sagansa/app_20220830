<?php

namespace App\Policies;

use App\Models\User;
use App\Models\DailySalary;
use Illuminate\Auth\Access\HandlesAuthorization;

class DailySalaryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the dailySalary can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list dailysalaries');
    }

    /**
     * Determine whether the dailySalary can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DailySalary  $model
     * @return mixed
     */
    public function view(User $user, DailySalary $model)
    {
        return $user->hasPermissionTo('view dailysalaries');
    }

    /**
     * Determine whether the dailySalary can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create dailysalaries');
    }

    /**
     * Determine whether the dailySalary can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DailySalary  $model
     * @return mixed
     */
    public function update(User $user, DailySalary $model)
    {
        return $user->hasPermissionTo('update dailysalaries');
    }

    /**
     * Determine whether the dailySalary can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DailySalary  $model
     * @return mixed
     */
    public function delete(User $user, DailySalary $model)
    {
        return $user->hasPermissionTo('delete dailysalaries');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DailySalary  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete dailysalaries');
    }

    /**
     * Determine whether the dailySalary can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DailySalary  $model
     * @return mixed
     */
    public function restore(User $user, DailySalary $model)
    {
        return false;
    }

    /**
     * Determine whether the dailySalary can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DailySalary  $model
     * @return mixed
     */
    public function forceDelete(User $user, DailySalary $model)
    {
        return false;
    }
}
