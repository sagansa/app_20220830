<?php

namespace App\Http\Controllers\Api;

use App\Models\Presence;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\PresenceResource;
use App\Http\Resources\PresenceCollection;
use App\Http\Requests\PresenceStoreRequest;
use App\Http\Requests\PresenceUpdateRequest;

class PresenceController extends Controller
{
    public function index(Request $request): PresenceCollection
    {
        $this->authorize('view-any', Presence::class);

        $search = $request->get('search', '');

        $presences = Presence::search($search)
            ->latest()
            ->paginate();

        return new PresenceCollection($presences);
    }

    public function store(PresenceStoreRequest $request): PresenceResource
    {
        $this->authorize('create', Presence::class);

        $validated = $request->validated();
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

        $presence = Presence::create($validated);

        return new PresenceResource($presence);
    }

    public function show(Request $request, Presence $presence): PresenceResource
    {
        $this->authorize('view', $presence);

        return new PresenceResource($presence);
    }

    public function update(
        PresenceUpdateRequest $request,
        Presence $presence
    ): PresenceResource {
        $this->authorize('update', $presence);

        $validated = $request->validated();

        if ($request->hasFile('image_in')) {
            if ($presence->image_in) {
                Storage::delete($presence->image_in);
            }

            $validated['image_in'] = $request
                ->file('image_in')
                ->store('public');
        }

        if ($request->hasFile('image_out')) {
            if ($presence->image_out) {
                Storage::delete($presence->image_out);
            }

            $validated['image_out'] = $request
                ->file('image_out')
                ->store('public');
        }

        $presence->update($validated);

        return new PresenceResource($presence);
    }

    public function destroy(Request $request, Presence $presence): Response
    {
        $this->authorize('delete', $presence);

        if ($presence->image_in) {
            Storage::delete($presence->image_in);
        }

        if ($presence->image_out) {
            Storage::delete($presence->image_out);
        }

        $presence->delete();

        return response()->noContent();
    }
}
