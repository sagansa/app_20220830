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
            'status' => ['required', 'max:255'],
            'image_in' => ['nullable', 'max:255', 'string'],
            'image_out' => ['nullable', 'max:255', 'string'],
            'lat_long_in' => ['nullable', 'max:255', 'string'],
            'lat_long_out' => ['nullable', 'max:255', 'string'],
            'created_by_id' => ['nullable', 'exists:users,id'],
            'approved_by_id' => ['nullable', 'exists:users,id'],
        ]);

        $presence = $shiftStore->presences()->create($validated);

        return new PresenceResource($presence);
    }
}
