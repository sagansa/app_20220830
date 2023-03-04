<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\AdminCashless;
use App\Models\AccountCashless;
use App\Http\Controllers\Controller;
use App\Http\Resources\AccountCashlessCollection;

class AdminCashlessAccountCashlessesController extends Controller
{
    public function index(
        Request $request,
        AdminCashless $adminCashless
    ): AccountCashlessCollection {
        $this->authorize('view', $adminCashless);

        $search = $request->get('search', '');

        $accountCashlesses = $adminCashless
            ->accountCashlesses()
            ->search($search)
            ->latest()
            ->paginate();

        return new AccountCashlessCollection($accountCashlesses);
    }

    public function store(
        Request $request,
        AdminCashless $adminCashless,
        AccountCashless $accountCashless
    ): Response {
        $this->authorize('update', $adminCashless);

        $adminCashless
            ->accountCashlesses()
            ->syncWithoutDetaching([$accountCashless->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        AdminCashless $adminCashless,
        AccountCashless $accountCashless
    ): Response {
        $this->authorize('update', $adminCashless);

        $adminCashless->accountCashlesses()->detach($accountCashless);

        return response()->noContent();
    }
}
