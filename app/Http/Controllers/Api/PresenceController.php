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
use Illuminate\Support\Carbon;
// use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
date_default_timezone_set("Asia/Jakarta");

class PresenceController extends Controller
{
    function getPresences()
    {
        $presences = Presence::where('created_by_id', Auth::user()->id)->get();
        foreach($presences as $item) {
            if ($item->date_in == date('Y-m-d')) {
                $item->is_hari_ini = true;
            } else {
                $item->is_hari_ini = false;
            }

            $datetime = Carbon::parse($item->date_in)->locale('id');
            $datetime = Carbon::parse($item->date_out)->locale('id');
            $time_in = Carbon::parse($item->time_in)->locale('id');
            $time_out = Carbon::parse($item->time_out)->locale('id');

            $datetime->settings(['formatFunction' => 'translatedFormat']);
            $time_in->settings(['formatFunction' => 'translatedFormat']);
            $time_out->settings(['formatFunction' => 'translatedFormat']);

            // $item->time_in = $time_in->format('h:i A');
            // $item->time_out = $time_out->format('h:i A');
        }

        return response()->json([
            'success' => true,
            'data' => $presences,
            'message' => 'Sukses menampilkan data'
        ]);
    }

    function savePresence(Request $request)
    {
        $keterangan = "";
        // $presence = Presence::whereDate('date_in', '=', date('Y-m-d'))
        //                 ->where('created_by_id', Auth::user()->id)
        //                 ->first();

        $presence = Presence::whereDate('created_at', '>=', Carbon::now()->subDay())
                        ->where('date_out', '=', NULL)
                        ->where('created_by_id', Auth::user()->id)
                        ->first();

        if ($presence == null) {
            $presence = Presence::create([
                'created_by_id' => Auth::user()->id,
                'latitude_in' => $request->latitude_in,
                'longitude_in' => $request->longitude_in,
                'status' => 1,
                'date_in' => date('Y-m-d'),
                'time_in' => date('H:i:s'),
                'store_id' => $request->store_id,
                'shift_store_id' => $request->shift_store_id,
                // 'image_in' => 1,
            ]);
        } else {
            $data = [
                'date_out' => date('Y-m-d'),
                'time_out' => date('H:i:s'),
                'latitude_out' => $request->latitude_out,
                'longitude_out' => $request->longitude_out,
            ];

            // Presence::whereDate('date_in', '=', date('Y-m-d'))->update($data);
            Presence::whereDate('created_at', '>=', Carbon::now()->subDay())->update($data);

        }
        // $presence = Presence::whereDate('date_in', '=', date('Y-m-d'))
        //          ->first();

        return response()->json([
            'success' => true,
            'data' => $presence,
            'message' => 'Sukses simpan'
        ]);
    }

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
