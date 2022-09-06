<?php
namespace App\Http\Controllers\Api;

use App\Models\Salary;
use App\Models\Presence;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PresenceCollection;

class SalaryPresencesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Salary $salary
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Salary $salary)
    {
        $this->authorize('view', $salary);

        $search = $request->get('search', '');

        $presences = $salary
            ->presences()
            ->search($search)
            ->latest()
            ->paginate();

        return new PresenceCollection($presences);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Salary $salary
     * @param \App\Models\Presence $presence
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Salary $salary, Presence $presence)
    {
        $this->authorize('update', $salary);

        $salary->presences()->syncWithoutDetaching([$presence->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Salary $salary
     * @param \App\Models\Presence $presence
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        Salary $salary,
        Presence $presence
    ) {
        $this->authorize('update', $salary);

        $salary->presences()->detach($presence);

        return response()->noContent();
    }
}
