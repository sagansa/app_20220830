<?php
namespace App\Http\Controllers\Api;

use App\Models\Presence;
use Illuminate\Http\Request;
use App\Models\MonthlySalary;
use App\Http\Controllers\Controller;
use App\Http\Resources\PresenceCollection;

class MonthlySalaryPresencesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\MonthlySalary $monthlySalary
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, MonthlySalary $monthlySalary)
    {
        $this->authorize('view', $monthlySalary);

        $search = $request->get('search', '');

        $presences = $monthlySalary
            ->presences()
            ->search($search)
            ->latest()
            ->paginate();

        return new PresenceCollection($presences);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\MonthlySalary $monthlySalary
     * @param \App\Models\Presence $presence
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        MonthlySalary $monthlySalary,
        Presence $presence
    ) {
        $this->authorize('update', $monthlySalary);

        $monthlySalary->presences()->syncWithoutDetaching([$presence->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\MonthlySalary $monthlySalary
     * @param \App\Models\Presence $presence
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        MonthlySalary $monthlySalary,
        Presence $presence
    ) {
        $this->authorize('update', $monthlySalary);

        $monthlySalary->presences()->detach($presence);

        return response()->noContent();
    }
}
