<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WorkingExperience;
use Illuminate\Auth\Access\HandlesAuthorization;

class WorkingExperiencePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the workingExperience can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list workingexperiences');
    }

    /**
     * Determine whether the workingExperience can view the model.
     */
    public function view(User $user, WorkingExperience $model): bool
    {
        return $user->hasPermissionTo('view workingexperiences');
    }

    /**
     * Determine whether the workingExperience can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create workingexperiences');
    }

    /**
     * Determine whether the workingExperience can update the model.
     */
    public function update(User $user, WorkingExperience $model): bool
    {
        return $user->hasPermissionTo('update workingexperiences');
    }

    /**
     * Determine whether the workingExperience can delete the model.
     */
    public function delete(User $user, WorkingExperience $model): bool
    {
        return $user->hasPermissionTo('delete workingexperiences');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete workingexperiences');
    }

    /**
     * Determine whether the workingExperience can restore the model.
     */
    public function restore(User $user, WorkingExperience $model): bool
    {
        return false;
    }

    /**
     * Determine whether the workingExperience can permanently delete the model.
     */
    public function forceDelete(User $user, WorkingExperience $model): bool
    {
        return false;
    }
}
