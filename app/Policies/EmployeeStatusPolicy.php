<?php

namespace App\Policies;

use App\Models\User;
use App\Models\EmployeeStatus;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmployeeStatusPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the employeeStatus can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list employeestatuses');
    }

    /**
     * Determine whether the employeeStatus can view the model.
     */
    public function view(User $user, EmployeeStatus $model): bool
    {
        return $user->hasPermissionTo('view employeestatuses');
    }

    /**
     * Determine whether the employeeStatus can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create employeestatuses');
    }

    /**
     * Determine whether the employeeStatus can update the model.
     */
    public function update(User $user, EmployeeStatus $model): bool
    {
        return $user->hasPermissionTo('update employeestatuses');
    }

    /**
     * Determine whether the employeeStatus can delete the model.
     */
    public function delete(User $user, EmployeeStatus $model): bool
    {
        return $user->hasPermissionTo('delete employeestatuses');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete employeestatuses');
    }

    /**
     * Determine whether the employeeStatus can restore the model.
     */
    public function restore(User $user, EmployeeStatus $model): bool
    {
        return false;
    }

    /**
     * Determine whether the employeeStatus can permanently delete the model.
     */
    public function forceDelete(User $user, EmployeeStatus $model): bool
    {
        return false;
    }
}
