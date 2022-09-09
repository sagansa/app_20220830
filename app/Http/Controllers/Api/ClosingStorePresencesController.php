<?php
namespace App\Http\Controllers\Api;

use App\Models\Presence;
use Illuminate\Http\Request;
use App\Models\ClosingStore;
use App\Http\Controllers\Controller;
use App\Http\Resources\PresenceCollection;

class ClosingStorePresencesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ClosingStore $closingStore
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, ClosingStore $closingStore)
    {
        $this->authorize('view', $closingStore);

        $search = $request->get('search', '');

        $presences = $closingStore
            ->presences()
            ->search($search)
            ->latest()
            ->paginate();

        return new PresenceCollection($presences);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ClosingStore $closingStore
     * @param \App\Models\Presence $presence
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        ClosingStore $closingStore,
        Presence $presence
    ) {
        $this->authorize('update', $closingStore);

        $closingStore->presences()->syncWithoutDetaching([$presence->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ClosingStore $closingStore
     * @param \App\Models\Presence $presence
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        ClosingStore $closingStore,
        Presence $presence
    ) {
        $this->authorize('update', $closingStore);

        $closingStore->presences()->detach($presence);

        return response()->noContent();
    }
}
