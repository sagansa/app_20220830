<?php
namespace App\Http\Controllers\Api;

use App\Models\Presence;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\MonthlySalary;
use App\Http\Controllers\Controller;
use App\Http\Resources\PresenceCollection;

class MonthlySalaryPresencesController extends Controller
{
    public function index(
        Request $request,
        MonthlySalary $monthlySalary
    ): PresenceCollection {
        $this->authorize('view', $monthlySalary);

        $search = $request->get('search', '');

        $presences = $monthlySalary
            ->presences()
            ->search($search)
            ->latest()
            ->paginate();

        return new PresenceCollection($presences);
    }

    public function store(
        Request $request,
        MonthlySalary $monthlySalary,
        Presence $presence
    ): Response {
        $this->authorize('update', $monthlySalary);

        $monthlySalary->presences()->syncWithoutDetaching([$presence->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        MonthlySalary $monthlySalary,
        Presence $presence
    ): Response {
        $this->authorize('update', $monthlySalary);

        $monthlySalary->presences()->detach($presence);

        return response()->noContent();
    }
}
