<?php

namespace App\Http\Controllers;

use Image;
use App\Models\User;
use App\Models\Village;
use App\Models\Regency;
use App\Models\Province;
use App\Models\District;
use Illuminate\Http\Request;
use App\Models\DeliveryLocation;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\DeliveryLocationStoreRequest;
use App\Http\Requests\DeliveryLocationUpdateRequest;

class DeliveryLocationController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', DeliveryLocation::class);

        $search = $request->get('search', '');

        $deliveryLocations = DeliveryLocation::search($search)
            ->where('user_id', '=', auth()->user()->id)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'app.delivery_locations.index',
            compact('deliveryLocations', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $villages = Village::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $users = User::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $provinces = Province::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $regencies = Regency::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $districts = District::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');

        return view(
            'app.delivery_locations.create',
            compact('villages', 'users', 'provinces', 'regencies', 'districts')
        );
    }

    /**
     * @param \App\Http\Requests\DeliveryLocationStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(DeliveryLocationStoreRequest $request)
    {
        $this->authorize('create', DeliveryLocation::class);

        $validated = $request->validated();

        $validated['user_id'] = auth()->user()->id;

        $deliveryLocation = DeliveryLocation::create($validated);

        return redirect()
            ->route('delivery-locations.edit', $deliveryLocation)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DeliveryLocation $deliveryLocation
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, DeliveryLocation $deliveryLocation)
    {
        $this->authorize('view', $deliveryLocation);

        return view('app.delivery_locations.show', compact('deliveryLocation'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DeliveryLocation $deliveryLocation
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, DeliveryLocation $deliveryLocation)
    {
        $this->authorize('update', $deliveryLocation);

        $villages = Village::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $users = User::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $provinces = Province::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $regencies = Regency::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $districts = District::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');

        return view(
            'app.delivery_locations.edit',
            compact(
                'deliveryLocation',
                'villages',
                'users',
                'provinces',
                'regencies',
                'districts'
            )
        );
    }

    /**
     * @param \App\Http\Requests\DeliveryLocationUpdateRequest $request
     * @param \App\Models\DeliveryLocation $deliveryLocation
     * @return \Illuminate\Http\Response
     */
    public function update(
        DeliveryLocationUpdateRequest $request,
        DeliveryLocation $deliveryLocation
    ) {
        $this->authorize('update', $deliveryLocation);

        $validated = $request->validated();

        if (
            auth()
                ->user()
                ->hasRole('supervisor|manager|super-admin')
        ) {
            $validated['approved_by_id'] = auth()->user()->id;
        }

        $deliveryLocation->update($validated);

        return redirect()
            ->route('delivery-locations.index')
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DeliveryLocation $deliveryLocation
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        DeliveryLocation $deliveryLocation
    ) {
        $this->authorize('delete', $deliveryLocation);

        $deliveryLocation->delete();

        return redirect()
            ->route('delivery-locations.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
