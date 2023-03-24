<?php

namespace App\Http\Controllers;

use Image;
use App\Models\User;
use App\Models\Store;
use App\Models\Presence;
use App\Models\ShiftStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\PresenceStoreRequest;
use App\Http\Requests\PresenceUpdateRequest;

class PresenceController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Presence::class);

        $search = $request->get('search', '');

        $presences = Presence::search($search)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('app.presences.index', compact('presences', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $stores = Store::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $shiftStores = ShiftStore::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $users = User::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');

        return view(
            'app.presences.create',
            compact('stores', 'shiftStores', 'users', 'users')
        );
    }

    /**
     * @param \App\Http\Requests\PresenceStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PresenceStoreRequest $request)
    {
        $this->authorize('create', Presence::class);

        $validated = $request->validated();

        if ($request->hasFile('image_in')) {
            $file = $request->file('image_in');
            $extension = $file->getClientOriginalExtension();
            $fileimage_in = rand() . time() . '.' . $extension;
            $file->move('storage/', $fileimage_in);
            Image::make('storage/' . $fileimage_in)
                ->resize(400, 400, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save();

            $validated['image_in'] = $fileimage_in;
        }

        if ($request->hasFile('image_out')) {
            $file = $request->file('image_out');
            $extension = $file->getClientOriginalExtension();
            $fileimage_out = rand() . time() . '.' . $extension;
            $file->move('storage/', $fileimage_out);
            Image::make('storage/' . $fileimage_out)
                ->resize(400, 400, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save();

            $validated['image_out'] = $fileimage_out;
        }

        $validated['created_by_id'] = auth()->user()->id;
        $validated['status'] = '1';

        $presence = Presence::create($validated);

        return redirect()
            ->route('presences.edit', $presence)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Presence $presence
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Presence $presence)
    {
        $this->authorize('view', $presence);

        return view('app.presences.show', compact('presence'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Presence $presence
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Presence $presence)
    {
        $this->authorize('update', $presence);

        $stores = Store::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $shiftStores = ShiftStore::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $users = User::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');

        return view(
            'app.presences.edit',
            compact('presence', 'stores', 'shiftStores', 'users', 'users')
        );
    }

    /**
     * @param \App\Http\Requests\PresenceUpdateRequest $request
     * @param \App\Models\Presence $presence
     * @return \Illuminate\Http\Response
     */
    public function update(PresenceUpdateRequest $request, Presence $presence)
    {
        $this->authorize('update', $presence);

        $validated = $request->validated();
        if ($request->hasFile('image_in')) {
            $file = $request->file('image_in');
            $presence->delete_image_in();
            $extension = $file->getClientOriginalExtension();
            $file_image_in = rand() . time() . '.' . $extension;
            $file->move('storage/', $file_image_in);
            Image::make('storage/' . $file_image_in)
                ->resize(400, 400, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save();

            $validated['image_in'] = $file_image_in;
        }

        if ($request->hasFile('image_out')) {
            $file = $request->file('image_out');
            $presence->delete_image_out();
            $extension = $file->getClientOriginalExtension();
            $file_image_out = rand() . time() . '.' . $extension;
            $file->move('storage/', $file_image_out);
            Image::make('storage/' . $file_image_out)
                ->resize(400, 400, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save();

            $validated['image_out'] = $file_image_out;
        }

        if (
            auth()
                ->user()
                ->hasRole('supervisor|manager|super-admin')
        ) {
            $validated['approved_by_id'] = auth()->user()->id;
        }

        $presence->update($validated);

        return redirect()
            ->route('presences.index')
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Presence $presence
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Presence $presence)
    {
        $this->authorize('delete', $presence);

        if ($presence->image_in) {
            Storage::delete($presence->image_in);
        }

        if ($presence->image_out) {
            Storage::delete($presence->image_out);
        }

        $presence->delete();

        return redirect()
            ->route('presences.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
