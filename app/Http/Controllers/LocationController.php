<?php

namespace App\Http\Controllers;

use Image;
use App\Models\Store;
use App\Models\Village;
use App\Models\Regency;
use App\Models\Location;
use App\Models\Province;
use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LocationStoreRequest;
use App\Http\Requests\LocationUpdateRequest;

class LocationController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Location::class);

        $search = $request->get('search', '');

        $locations = Location::search($search)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('app.locations.index', compact('locations', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $stores = Store::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $villages = Village::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $provinces = Province::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $regencies = Regency::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $districts = District::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');

        return view(
            'app.locations.create',
            compact('stores', 'villages', 'provinces', 'regencies', 'districts')
        );
    }

    /**
     * @param \App\Http\Requests\LocationStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(LocationStoreRequest $request)
    {
        $this->authorize('create', Location::class);

        $validated = $request->validated();

        $validated['created_by_id'] = auth()->user()->id;
        $validated['status'] = '1';

        $location = Location::create($validated);

        return redirect()
            ->route('locations.edit', $location)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Location $location
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Location $location)
    {
        $this->authorize('view', $location);

        return view('app.locations.show', compact('location'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Location $location
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Location $location)
    {
        $this->authorize('update', $location);

        $stores = Store::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $villages = Village::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $provinces = Province::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $regencies = Regency::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $districts = District::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');

        return view(
            'app.locations.edit',
            compact(
                'location',
                'stores',
                'villages',
                'provinces',
                'regencies',
                'districts'
            )
        );
    }

    /**
     * @param \App\Http\Requests\LocationUpdateRequest $request
     * @param \App\Models\Location $location
     * @return \Illuminate\Http\Response
     */
    public function update(LocationUpdateRequest $request, Location $location)
    {
        $this->authorize('update', $location);

        $validated = $request->validated();

        if (
            auth()
                ->user()
                ->hasRole('supervisor|manager|super-admin')
        ) {
            $validated['approved_by_id'] = auth()->user()->id;
        }

        $location->update($validated);

        return redirect()
            ->route('locations.index')
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Location $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Location $location)
    {
        $this->authorize('delete', $location);

        $location->delete();

        return redirect()
            ->route('locations.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
