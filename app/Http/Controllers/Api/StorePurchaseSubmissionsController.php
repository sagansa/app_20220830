<?php

namespace App\Http\Controllers\Api;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PurchaseSubmissionResource;
use App\Http\Resources\PurchaseSubmissionCollection;

class StorePurchaseSubmissionsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Store $store
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Store $store)
    {
        $this->authorize('view', $store);

        $search = $request->get('search', '');

        $purchaseSubmissions = $store
            ->purchaseSubmissions()
            ->search($search)
            ->latest()
            ->paginate();

        return new PurchaseSubmissionCollection($purchaseSubmissions);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Store $store
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Store $store)
    {
        $this->authorize('create', PurchaseSubmission::class);

        $validated = $request->validate([
            'date' => ['required', 'date'],
            'user_id' => ['required', 'exists:users,id'],
        ]);

        $purchaseSubmission = $store->purchaseSubmissions()->create($validated);

        return new PurchaseSubmissionResource($purchaseSubmission);
    }
}
