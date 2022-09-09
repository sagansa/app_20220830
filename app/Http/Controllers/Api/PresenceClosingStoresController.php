<?php
namespace App\Http\Controllers\Api;

use App\Models\Presence;
use Illuminate\Http\Request;
use App\Models\ClosingStore;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClosingStoreCollection;

class PresenceClosingStoresController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Presence $presence
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Presence $presence)
    {
        $this->authorize('view', $presence);

        $search = $request->get('search', '');

        $closingStores = $presence
            ->closingStores()
            ->search($search)
            ->latest()
            ->paginate();

        return new ClosingStoreCollection($closingStores);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Presence $presence
     * @param \App\Models\ClosingStore $closingStore
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        Presence $presence,
        ClosingStore $closingStore
    ) {
        $this->authorize('update', $presence);

        $presence->closingStores()->syncWithoutDetaching([$closingStore->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Presence $presence
     * @param \App\Models\ClosingStore $closingStore
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        Presence $presence,
        ClosingStore $closingStore
    ) {
        $this->authorize('update', $presence);

        $presence->closingStores()->detach($closingStore);

        return response()->noContent();
    }
}
