<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\AdminCashless;
use App\Models\AccountCashless;
use App\Http\Controllers\Controller;
use App\Http\Resources\AdminCashlessCollection;

class AccountCashlessAdminCashlessesController extends Controller
{
    public function index(
        Request $request,
        AccountCashless $accountCashless
    ): AdminCashlessCollection {
        $this->authorize('view', $accountCashless);

        $search = $request->get('search', '');

        $adminCashlesses = $accountCashless
            ->adminCashlesses()
            ->search($search)
            ->latest()
            ->paginate();

        return new AdminCashlessCollection($adminCashlesses);
    }

    public function store(
        Request $request,
        AccountCashless $accountCashless,
        AdminCashless $adminCashless
    ): Response {
        $this->authorize('update', $accountCashless);

        $accountCashless
            ->adminCashlesses()
            ->syncWithoutDetaching([$adminCashless->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        AccountCashless $accountCashless,
        AdminCashless $adminCashless
    ): Response {
        $this->authorize('update', $accountCashless);

        $accountCashless->adminCashlesses()->detach($adminCashless);

        return response()->noContent();
    }
}
