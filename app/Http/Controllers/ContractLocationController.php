<?php

namespace App\Http\Controllers;

use Image;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Models\ContractLocation;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ContractLocationStoreRequest;
use App\Http\Requests\ContractLocationUpdateRequest;

class ContractLocationController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', ContractLocation::class);

        $search = $request->get('search', '');

        $contractLocations = ContractLocation::search($search)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'app.contract_locations.index',
            compact('contractLocations', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $locations = Location::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');

        return view('app.contract_locations.create', compact('locations'));
    }

    /**
     * @param \App\Http\Requests\ContractLocationStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContractLocationStoreRequest $request)
    {
        $this->authorize('create', ContractLocation::class);

        $validated = $request->validated();

        $validated['created_by_id'] = auth()->user()->id;
        $validated['status'] = '1';

        $contractLocation = ContractLocation::create($validated);

        return redirect()
            ->route('contract-locations.edit', $contractLocation)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ContractLocation $contractLocation
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, ContractLocation $contractLocation)
    {
        $this->authorize('view', $contractLocation);

        return view('app.contract_locations.show', compact('contractLocation'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ContractLocation $contractLocation
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, ContractLocation $contractLocation)
    {
        $this->authorize('update', $contractLocation);

        $locations = Location::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');

        return view(
            'app.contract_locations.edit',
            compact('contractLocation', 'locations')
        );
    }

    /**
     * @param \App\Http\Requests\ContractLocationUpdateRequest $request
     * @param \App\Models\ContractLocation $contractLocation
     * @return \Illuminate\Http\Response
     */
    public function update(
        ContractLocationUpdateRequest $request,
        ContractLocation $contractLocation
    ) {
        $this->authorize('update', $contractLocation);

        $validated = $request->validated();

        if (
            auth()
                ->user()
                ->hasRole('supervisor|manager|super-admin')
        ) {
            $validated['approved_by_id'] = auth()->user()->id;
        }

        $contractLocation->update($validated);

        return redirect()
            ->route('contract-locations.index')
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ContractLocation $contractLocation
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        ContractLocation $contractLocation
    ) {
        $this->authorize('delete', $contractLocation);

        $contractLocation->delete();

        return redirect()
            ->route('contract-locations.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
