<?php

namespace App\Http\Controllers\Api;

use App\Models\ShiftStore;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PresenceResource;
use App\Http\Resources\PresenceCollection;

class ShiftStorePresencesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ShiftStore $shiftStore
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, ShiftStore $shiftStore)
    {
        $this->authorize('view', $shiftStore);

        $search = $request->get('search', '');

        $presences = $shiftStore
            ->presences()
            ->search($search)
            ->latest()
            ->paginate();

        return new PresenceCollection($presences);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ShiftStore $shiftStore
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, ShiftStore $shiftStore)
    {
        $this->authorize('create', Presence::class);

        $validated = $request->validate([
            'store_id' => ['required', 'exists:stores,id'],
            'date' => ['required', 'date'],
            'amount' => ['required', 'numeric', 'gt:0'],
            'payment_type_id' => ['required', 'exists:payment_types,id'],
            'status' => ['required', 'in:1,2,3,4'],
            'created_by_id' => ['nullable', 'exists:users,id'],
        ]);

        $presence = $shiftStore->presences()->create($validated);

        return new PresenceResource($presence);
    }
}
