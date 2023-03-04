<?php
namespace App\Http\Controllers\Api;

use App\Models\DailySalary;
use Illuminate\Http\Request;
use App\Models\ClosingStore;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClosingStoreCollection;

class DailySalaryClosingStoresController extends Controller
{
    public function index(
        Request $request,
        DailySalary $dailySalary
    ): ClosingStoreCollection {
        $this->authorize('view', $dailySalary);

        $search = $request->get('search', '');

        $closingStores = $dailySalary
            ->closingStores()
            ->search($search)
            ->latest()
            ->paginate();

        return new ClosingStoreCollection($closingStores);
    }

    public function store(
        Request $request,
        DailySalary $dailySalary,
        ClosingStore $closingStore
    ): Response {
        $this->authorize('update', $dailySalary);

        $dailySalary
            ->closingStores()
            ->syncWithoutDetaching([$closingStore->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        DailySalary $dailySalary,
        ClosingStore $closingStore
    ): Response {
        $this->authorize('update', $dailySalary);

        $dailySalary->closingStores()->detach($closingStore);

        return response()->noContent();
    }
}
