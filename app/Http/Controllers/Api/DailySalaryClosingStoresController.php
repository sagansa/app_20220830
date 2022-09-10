<?php
namespace App\Http\Controllers\Api;

use App\Models\DailySalary;
use Illuminate\Http\Request;
use App\Models\ClosingStore;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClosingStoreCollection;

class DailySalaryClosingStoresController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DailySalary $dailySalary
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, DailySalary $dailySalary)
    {
        $this->authorize('view', $dailySalary);

        $search = $request->get('search', '');

        $closingStores = $dailySalary
            ->closingStores()
            ->search($search)
            ->latest()
            ->paginate();

        return new ClosingStoreCollection($closingStores);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DailySalary $dailySalary
     * @param \App\Models\ClosingStore $closingStore
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        DailySalary $dailySalary,
        ClosingStore $closingStore
    ) {
        $this->authorize('update', $dailySalary);

        $dailySalary
            ->closingStores()
            ->syncWithoutDetaching([$closingStore->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DailySalary $dailySalary
     * @param \App\Models\ClosingStore $closingStore
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        DailySalary $dailySalary,
        ClosingStore $closingStore
    ) {
        $this->authorize('update', $dailySalary);

        $dailySalary->closingStores()->detach($closingStore);

        return response()->noContent();
    }
}
