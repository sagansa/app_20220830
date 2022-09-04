<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PurchaseSubmissionResource;
use App\Http\Resources\PurchaseSubmissionCollection;

class UserPurchaseSubmissionsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, User $user)
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $purchaseSubmissions = $user
            ->purchaseSubmissions()
            ->search($search)
            ->latest()
            ->paginate();

        return new PurchaseSubmissionCollection($purchaseSubmissions);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', PurchaseSubmission::class);

        $validated = $request->validate([
            'store_id' => ['required', 'exists:stores,id'],
            'date' => ['required', 'date'],
        ]);

        $purchaseSubmission = $user->purchaseSubmissions()->create($validated);

        return new PurchaseSubmissionResource($purchaseSubmission);
    }
}
