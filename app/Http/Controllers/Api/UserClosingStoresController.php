<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClosingStoreResource;
use App\Http\Resources\ClosingStoreCollection;

class UserClosingStoresController extends Controller
{
    public function index(Request $request, User $user): ClosingStoreCollection
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $closingStores = $user
            ->closingStoresApproved()
            ->search($search)
            ->latest()
            ->paginate();

        return new ClosingStoreCollection($closingStores);
    }

    public function store(Request $request, User $user): ClosingStoreResource
    {
        $this->authorize('create', ClosingStore::class);

        $validated = $request->validate([
            'store_id' => ['required', 'exists:stores,id'],
            'shift_store_id' => ['required', 'exists:shift_stores,id'],
            'date' => ['required', 'date'],
            'cash_from_yesterday' => ['required'],
            'cash_for_tomorrow' => ['required'],
            'total_cash_transfer' => ['required'],
            'status' => ['required', 'max:255'],
            'notes' => ['nullable', 'max:255', 'string'],
        ]);

        $closingStore = $user->closingStoresApproved()->create($validated);

        return new ClosingStoreResource($closingStore);
    }
}
