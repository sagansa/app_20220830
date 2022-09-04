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
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list paymentreceipts');
    }

    /**
     * Determine whether the paymentReceipt can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\PaymentReceipt  $model
     * @return mixed
     */
    public function view(User $user, PaymentReceipt $model)
    {
        return $user->hasPermissionTo('view paymentreceipts');
    }

    /**
     * Determine whether the paymentReceipt can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create paymentreceipts');
    }

    /**
     * Determine whether the paymentReceipt can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\PaymentReceipt  $model
     * @return mixed
     */
    public function update(User $user, PaymentReceipt $model)
    {
        return $user->hasPermissionTo('update paymentreceipts');
    }

    /**
     * Determine whether the paymentReceipt can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\PaymentReceipt  $model
     * @return mixed
     */
    public function delete(User $user, PaymentReceipt $model)
    {
        return $user->hasPermissionTo('delete paymentreceipts');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\PaymentReceipt  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete paymentreceipts');
    }

    /**
     * Determine whether the paymentReceipt can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\PaymentReceipt  $model
     * @return mixed
     */
    public function restore(User $user, PaymentReceipt $model)
    {
        return false;
    }

    /**
     * Determine whether the paymentReceipt can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\PaymentReceipt  $model
     * @return mixed
     */
    public function forceDelete(User $user, PaymentReceipt $model)
    {
        return false;
    }
}
