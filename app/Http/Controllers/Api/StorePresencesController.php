<?php

namespace App\Http\Controllers\Api;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PresenceResource;
use App\Http\Resources\PresenceCollection;

class StorePresencesController extends Controller
{
    public function index(Request $request, Store $store): PresenceCollection
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

    public function store(Request $request, Store $store): PresenceResource
    {
        $this->authorize('create', Presence::class);

        $validated = $request->validate([
            'shift_store_id' => ['required', 'exists:shift_stores,id'],
            'date_in' => ['required', 'date'],
            'time_in' => ['required', 'date_format:H:i:s'],
            'latitude_in' => ['required', 'numeric'],
            'longitude_in' => ['required', 'numeric'],
            'image_in' => ['image', 'nullable'],
            'created_by_id' => ['nullable', 'exists:users,id'],
            'approved_by_id' => ['nullable', 'exists:users,id'],
            'date_out' => ['required', 'date'],
            'time_out' => ['nullable', 'date_format:H:i:s'],
            'latitude_out' => ['nullable', 'numeric'],
            'longitude_out' => ['nullable', 'numeric'],
            'image_out' => ['image', 'nullable'],
            'status' => ['required'],
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

        $presence = $store->presences()->create($validated);

        return new PresenceResource($presence);
    }
}
