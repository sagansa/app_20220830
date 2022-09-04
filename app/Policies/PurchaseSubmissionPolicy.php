<?php

namespace App\Policies;

use App\Models\User;
use App\Models\PurchaseSubmission;
use Illuminate\Auth\Access\HandlesAuthorization;

class PurchaseSubmissionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the purchaseSubmission can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list purchasesubmissions');
    }

    /**
     * Determine whether the purchaseSubmission can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\PurchaseSubmission  $model
     * @return mixed
     */
    public function view(User $user, PurchaseSubmission $model)
    {
        return $user->hasPermissionTo('view purchasesubmissions');
    }

    /**
     * Determine whether the purchaseSubmission can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create purchasesubmissions');
    }

    /**
     * Determine whether the purchaseSubmission can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\PurchaseSubmission  $model
     * @return mixed
     */
    public function update(User $user, PurchaseSubmission $model)
    {
        return $user->hasPermissionTo('update purchasesubmissions');
    }

    /**
     * Determine whether the purchaseSubmission can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\PurchaseSubmission  $model
     * @return mixed
     */
    public function delete(User $user, PurchaseSubmission $model)
    {
        return $user->hasPermissionTo('delete purchasesubmissions');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\PurchaseSubmission  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete purchasesubmissions');
    }

    /**
     * Determine whether the purchaseSubmission can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\PurchaseSubmission  $model
     * @return mixed
     */
    public function restore(User $user, PurchaseSubmission $model)
    {
        return false;
    }

    /**
     * Determine whether the purchaseSubmission can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\PurchaseSubmission  $model
     * @return mixed
     */
    public function forceDelete(User $user, PurchaseSubmission $model)
    {
        return false;
    }
}
