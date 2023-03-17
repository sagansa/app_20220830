<?php
namespace App\Http\Controllers\Api;

use App\Models\Presence;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\MonthlySalary;
use App\Http\Controllers\Controller;
use App\Http\Resources\MonthlySalaryCollection;

class PresenceMonthlySalariesController extends Controller
{
    public function index(
        Request $request,
        Presence $presence
    ): MonthlySalaryCollection {
        $this->authorize('view', $presence);

        $search = $request->get('search', '');

        $monthlySalaries = $presence
            ->monthlySalaries()
            ->search($search)
            ->latest()
            ->paginate();

        return new MonthlySalaryCollection($monthlySalaries);
    }

    public function store(
        Request $request,
        Presence $presence,
        MonthlySalary $monthlySalary
    ): Response {
        $this->authorize('update', $presence);

        $presence
            ->monthlySalaries()
            ->syncWithoutDetaching([$monthlySalary->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        Presence $presence,
        MonthlySalary $monthlySalary
    ): Response {
        $this->authorize('update', $presence);

        $presence->monthlySalaries()->detach($monthlySalary);

        return response()->noContent();
    }
}
