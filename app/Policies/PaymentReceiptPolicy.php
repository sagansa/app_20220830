<?php

namespace App\Policies;

use App\Models\User;
use App\Models\PaymentReceipt;
use Illuminate\Auth\Access\HandlesAuthorization;

class PaymentReceiptPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the paymentReceipt can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list paymentreceipts');
    }

    /**
     * Determine whether the paymentReceipt can view the model.
     */
    public function view(User $user, PaymentReceipt $model): bool
    {
        return $user->hasPermissionTo('view paymentreceipts');
    }

    /**
     * Determine whether the paymentReceipt can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create paymentreceipts');
    }

    /**
     * Determine whether the paymentReceipt can update the model.
     */
    public function update(User $user, PaymentReceipt $model): bool
    {
        return $user->hasPermissionTo('update paymentreceipts');
    }

    /**
     * Determine whether the paymentReceipt can delete the model.
     */
    public function delete(User $user, PaymentReceipt $model): bool
    {
        return $user->hasPermissionTo('delete paymentreceipts');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete paymentreceipts');
    }

    /**
     * Determine whether the paymentReceipt can restore the model.
     */
    public function restore(User $user, PaymentReceipt $model): bool
    {
        return false;
    }

    /**
     * Determine whether the paymentReceipt can permanently delete the model.
     */
    public function forceDelete(User $user, PaymentReceipt $model): bool
    {
        return false;
    }
}
