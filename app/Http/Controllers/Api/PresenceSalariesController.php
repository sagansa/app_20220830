<?php
namespace App\Http\Controllers\Api;

use App\Models\Salary;
use App\Models\Presence;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SalaryCollection;

class PresenceSalariesController extends Controller
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

        $salaries = $presence
            ->salaries()
            ->search($search)
            ->latest()
            ->paginate();

        return new SalaryCollection($salaries);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Presence $presence
     * @param \App\Models\Salary $salary
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Presence $presence, Salary $salary)
    {
        $this->authorize('update', $presence);

        $presence->salaries()->syncWithoutDetaching([$salary->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Presence $presence
     * @param \App\Models\Salary $salary
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        Presence $presence,
        Salary $salary
    ) {
        $this->authorize('update', $presence);

        $presence->salaries()->detach($salary);

        return response()->noContent();
    }
}
