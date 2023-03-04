<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ReceiptLoyverse;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReceiptLoyversePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the receiptLoyverse can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list receiptloyverses');
    }

    /**
     * Determine whether the receiptLoyverse can view the model.
     */
    public function view(User $user, ReceiptLoyverse $model): bool
    {
        return $user->hasPermissionTo('view receiptloyverses');
    }

    /**
     * Determine whether the receiptLoyverse can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create receiptloyverses');
    }

    /**
     * Determine whether the receiptLoyverse can update the model.
     */
    public function update(User $user, ReceiptLoyverse $model): bool
    {
        return $user->hasPermissionTo('update receiptloyverses');
    }

    /**
     * Determine whether the receiptLoyverse can delete the model.
     */
    public function delete(User $user, ReceiptLoyverse $model): bool
    {
        return $user->hasPermissionTo('delete receiptloyverses');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete receiptloyverses');
    }

    /**
     * Determine whether the receiptLoyverse can restore the model.
     */
    public function restore(User $user, ReceiptLoyverse $model): bool
    {
        return false;
    }

    /**
     * Determine whether the receiptLoyverse can permanently delete the model.
     */
    public function forceDelete(User $user, ReceiptLoyverse $model): bool
    {
        return false;
    }
}
