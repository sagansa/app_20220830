<?php

namespace App\Policies;

use App\Models\User;
use App\Models\CashlessProvider;
use Illuminate\Auth\Access\HandlesAuthorization;

class CashlessProviderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the cashlessProvider can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list cashlessproviders');
    }

    /**
     * Determine whether the cashlessProvider can view the model.
     */
    public function view(User $user, CashlessProvider $model): bool
    {
        return $user->hasPermissionTo('view cashlessproviders');
    }

    /**
     * Determine whether the cashlessProvider can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create cashlessproviders');
    }

    /**
     * Determine whether the cashlessProvider can update the model.
     */
    public function update(User $user, CashlessProvider $model): bool
    {
        return $user->hasPermissionTo('update cashlessproviders');
    }

    /**
     * Determine whether the cashlessProvider can delete the model.
     */
    public function delete(User $user, CashlessProvider $model): bool
    {
        return $user->hasPermissionTo('delete cashlessproviders');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete cashlessproviders');
    }

    /**
     * Determine whether the cashlessProvider can restore the model.
     */
    public function restore(User $user, CashlessProvider $model): bool
    {
        return false;
    }

    /**
     * Determine whether the cashlessProvider can permanently delete the model.
     */
    public function forceDelete(User $user, CashlessProvider $model): bool
    {
        return false;
    }
}
