<?php

namespace App\Policies;

use App\Models\User;
use App\Models\MonthlySalary;
use Illuminate\Auth\Access\HandlesAuthorization;

class MonthlySalaryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the monthlySalary can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list monthlysalaries');
    }

    /**
     * Determine whether the monthlySalary can view the model.
     */
    public function view(User $user, MonthlySalary $model): bool
    {
        return $user->hasPermissionTo('view monthlysalaries');
    }

    /**
     * Determine whether the monthlySalary can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create monthlysalaries');
    }

    /**
     * Determine whether the monthlySalary can update the model.
     */
    public function update(User $user, MonthlySalary $model): bool
    {
        return $user->hasPermissionTo('update monthlysalaries');
    }

    /**
     * Determine whether the monthlySalary can delete the model.
     */
    public function delete(User $user, MonthlySalary $model): bool
    {
        return $user->hasPermissionTo('delete monthlysalaries');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete monthlysalaries');
    }

    /**
     * Determine whether the monthlySalary can restore the model.
     */
    public function restore(User $user, MonthlySalary $model): bool
    {
        return false;
    }

    /**
     * Determine whether the monthlySalary can permanently delete the model.
     */
    public function forceDelete(User $user, MonthlySalary $model): bool
    {
        return false;
    }
}
