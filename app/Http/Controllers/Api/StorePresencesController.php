<?php

namespace App\Http\Controllers\Api;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PresenceResource;
use App\Http\Resources\PresenceCollection;

class StorePresencesController extends Controller
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

        $presences = $store
            ->presences()
            ->search($search)
            ->latest()
            ->paginate();

        return new PresenceCollection($presences);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Store $store
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Store $store)
    {
        $this->authorize('create', Presence::class);

        $validated = $request->validate([
            'shift_store_id' => ['required', 'exists:shift_stores,id'],
            'status' => ['required', 'max:255'],
            'image_in' => ['nullable', 'max:255', 'string'],
            'image_out' => ['nullable', 'max:255', 'string'],
            'lat_long_in' => ['nullable', 'max:255', 'string'],
            'lat_long_out' => ['nullable', 'max:255', 'string'],
            'created_by_id' => ['nullable', 'exists:users,id'],
            'approved_by_id' => ['nullable', 'exists:users,id'],
        ]);

        $presence = $store->presences()->create($validated);

        return new PresenceResource($presence);
    }
}
