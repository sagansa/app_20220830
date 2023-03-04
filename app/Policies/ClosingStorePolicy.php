<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ClosingStore;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClosingStorePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the closingStore can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list closingstores');
    }

    /**
     * Determine whether the closingStore can view the model.
     */
    public function view(User $user, ClosingStore $model): bool
    {
        return $user->hasPermissionTo('view closingstores');
    }

    /**
     * Determine whether the closingStore can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create closingstores');
    }

    /**
     * Determine whether the closingStore can update the model.
     */
    public function update(User $user, ClosingStore $model): bool
    {
        return $user->hasPermissionTo('update closingstores');
    }

    /**
     * Determine whether the closingStore can delete the model.
     */
    public function delete(User $user, ClosingStore $model): bool
    {
        return $user->hasPermissionTo('delete closingstores');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete closingstores');
    }

    /**
     * Determine whether the closingStore can restore the model.
     */
    public function restore(User $user, ClosingStore $model): bool
    {
        return false;
    }

    /**
     * Determine whether the closingStore can permanently delete the model.
     */
    public function forceDelete(User $user, ClosingStore $model): bool
    {
        return false;
    }
}
