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
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list dailysalaries');
    }

    /**
     * Determine whether the dailySalary can view the model.
     */
    public function view(User $user, DailySalary $model): bool
    {
        return $user->hasPermissionTo('view dailysalaries');
    }

    /**
     * Determine whether the dailySalary can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create dailysalaries');
    }

    /**
     * Determine whether the dailySalary can update the model.
     */
    public function update(User $user, DailySalary $model): bool
    {
        return $user->hasPermissionTo('update dailysalaries');
    }

    /**
     * Determine whether the dailySalary can delete the model.
     */
    public function delete(User $user, DailySalary $model): bool
    {
        return $user->hasPermissionTo('delete dailysalaries');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete dailysalaries');
    }

    /**
     * Determine whether the dailySalary can restore the model.
     */
    public function restore(User $user, DailySalary $model): bool
    {
        return false;
    }

    /**
     * Determine whether the dailySalary can permanently delete the model.
     */
    public function forceDelete(User $user, DailySalary $model): bool
    {
        return false;
    }
}
