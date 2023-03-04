<?php

namespace App\Http\Controllers\Api;

use App\Models\ShiftStore;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PresenceResource;
use App\Http\Resources\PresenceCollection;

class ShiftStorePresencesController extends Controller
{
    public function index(
        Request $request,
        ShiftStore $shiftStore
    ): PresenceCollection {
        $this->authorize('view', $shiftStore);

        $search = $request->get('search', '');

        $presences = $shiftStore
            ->presences()
            ->search($search)
            ->latest()
            ->paginate();

        return new PresenceCollection($presences);
    }

    public function store(
        Request $request,
        ShiftStore $shiftStore
    ): PresenceResource {
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
