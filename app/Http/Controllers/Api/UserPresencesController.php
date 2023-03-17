<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PresenceResource;
use App\Http\Resources\PresenceCollection;

class UserPresencesController extends Controller
{
    public function index(Request $request, User $user): PresenceCollection
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $presences = $user
            ->presencesApproved()
            ->search($search)
            ->latest()
            ->paginate();

        return new PresenceCollection($presences);
    }

    public function store(Request $request, User $user): PresenceResource
    {
        $this->authorize('create', Presence::class);

        $validated = $request->validate([
            'store_id' => ['required', 'exists:stores,id'],
            'shift_store_id' => ['required', 'exists:shift_stores,id'],
            'date' => ['required', 'date'],
            'time_in' => ['required', 'date_format:H:i:s'],
            'time_out' => ['nullable', 'date_format:H:i:s'],
            'latitude_in' => ['required', 'numeric'],
            'longitude_in' => ['required', 'numeric'],
            'image_in' => ['image', 'max:1024', 'nullable'],
            'latitude_out' => ['nullable', 'numeric'],
            'longitude_out' => ['nullable', 'numeric'],
            'image_out' => ['image', 'max:1024', 'nullable'],
            'status' => ['required', 'max:255'],
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

        $presence = $user->presencesApproved()->create($validated);

        return new PresenceResource($presence);
    }
}
