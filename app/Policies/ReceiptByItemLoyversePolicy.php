<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ReceiptByItemLoyverse;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReceiptByItemLoyversePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the receiptByItemLoyverse can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list receiptbyitemloyverses');
    }

    /**
     * Determine whether the receiptByItemLoyverse can view the model.
     */
    public function view(User $user, ReceiptByItemLoyverse $model): bool
    {
        return $user->hasPermissionTo('view receiptbyitemloyverses');
    }

    /**
     * Determine whether the receiptByItemLoyverse can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create receiptbyitemloyverses');
    }

    /**
     * Determine whether the receiptByItemLoyverse can update the model.
     */
    public function update(User $user, ReceiptByItemLoyverse $model): bool
    {
        return $user->hasPermissionTo('update receiptbyitemloyverses');
    }

    /**
     * Determine whether the receiptByItemLoyverse can delete the model.
     */
    public function delete(User $user, ReceiptByItemLoyverse $model): bool
    {
        return $user->hasPermissionTo('delete receiptbyitemloyverses');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete receiptbyitemloyverses');
    }

    /**
     * Determine whether the receiptByItemLoyverse can restore the model.
     */
    public function restore(User $user, ReceiptByItemLoyverse $model): bool
    {
        return false;
    }

    /**
     * Determine whether the receiptByItemLoyverse can permanently delete the model.
     */
    public function forceDelete(User $user, ReceiptByItemLoyverse $model): bool
    {
        return false;
    }
}
