<?php

namespace App\Http\Controllers\Api;

use App\Models\Room;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\HygieneOfRoomResource;
use App\Http\Resources\HygieneOfRoomCollection;

class RoomHygieneOfRoomsController extends Controller
{
    public function index(Request $request, Room $room): HygieneOfRoomCollection
    {
        $this->authorize('view', $room);

        $search = $request->get('search', '');

        $hygieneOfRooms = $room
            ->hygieneOfRooms()
            ->search($search)
            ->latest()
            ->paginate();

        return new HygieneOfRoomCollection($hygieneOfRooms);
    }

    public function store(Request $request, Room $room): HygieneOfRoomResource
    {
        $this->authorize('create', HygieneOfRoom::class);

        $validated = $request->validate([
            'image' => ['nullable', 'image', 'max:1024'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $hygieneOfRoom = $room->hygieneOfRooms()->create($validated);

        return new HygieneOfRoomResource($hygieneOfRoom);
    }
}
