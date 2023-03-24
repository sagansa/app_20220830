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
            'date' => ['required', 'date'],
            'created_by_id' => ['nullable', 'exists:users,id'],
            'approved_by_id' => ['nullable', 'exists:users,id'],
            'latitude_in' => ['required', 'numeric'],
            'longitude_in' => ['required', 'numeric'],
            'image_in' => ['image', 'nullable'],
            'latitude_out' => ['nullable', 'numeric'],
            'longitude_out' => ['nullable', 'numeric'],
            'image_out' => ['image', 'nullable'],
            'status' => ['required', 'max:255'],
            'time_in' => ['required', 'date'],
            'time_out' => ['nullable', 'date'],
        ]);

        if ($request->hasFile('image_in')) {
            $validated['image_in'] = $request
                ->file('image_in')
                ->store('public');
        }

        if ($request->hasFile('image_out')) {
            $validated['image_out'] = $request
                ->file('image_out')
                ->store('public');
        }

        $presence = $shiftStore->presences()->create($validated);

        return new PresenceResource($presence);
    }
}
