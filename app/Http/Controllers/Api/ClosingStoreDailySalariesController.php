<?php
namespace App\Http\Controllers\Api;

use App\Models\DailySalary;
use Illuminate\Http\Request;
use App\Models\ClosingStore;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\DailySalaryCollection;

class ClosingStoreDailySalariesController extends Controller
{
    public function index(
        Request $request,
        ClosingStore $closingStore
    ): DailySalaryCollection {
        $this->authorize('view', $closingStore);

        $search = $request->get('search', '');

        $dailySalaries = $closingStore
            ->dailySalaries()
            ->search($search)
            ->latest()
            ->paginate();

        return new DailySalaryCollection($dailySalaries);
    }

    public function store(
        Request $request,
        ClosingStore $closingStore,
        DailySalary $dailySalary
    ): Response {
        $this->authorize('update', $closingStore);

        $closingStore
            ->dailySalaries()
            ->syncWithoutDetaching([$dailySalary->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        ClosingStore $closingStore,
        DailySalary $dailySalary
    ): Response {
        $this->authorize('update', $closingStore);

        $closingStore->dailySalaries()->detach($dailySalary);

        return response()->noContent();
    }
}
