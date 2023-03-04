<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\AccountCashless;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\AccountCashlessResource;
use App\Http\Resources\AccountCashlessCollection;
use App\Http\Requests\AccountCashlessStoreRequest;
use App\Http\Requests\AccountCashlessUpdateRequest;

class AccountCashlessController extends Controller
{
    public function index(Request $request): AccountCashlessCollection
    {
        $this->authorize('view-any', AccountCashless::class);

        $search = $request->get('search', '');

        $accountCashlesses = AccountCashless::search($search)
            ->latest()
            ->paginate();

        return new AccountCashlessCollection($accountCashlesses);
    }

    public function store(
        AccountCashlessStoreRequest $request
    ): AccountCashlessResource {
        $this->authorize('create', AccountCashless::class);

        $validated = $request->validated();

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $accountCashless = AccountCashless::create($validated);

        return new AccountCashlessResource($accountCashless);
    }

    public function show(
        Request $request,
        AccountCashless $accountCashless
    ): AccountCashlessResource {
        $this->authorize('view', $accountCashless);

        return new AccountCashlessResource($accountCashless);
    }

    public function update(
        AccountCashlessUpdateRequest $request,
        AccountCashless $accountCashless
    ): AccountCashlessResource {
        $this->authorize('update', $accountCashless);

        $validated = $request->validated();

        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        $accountCashless->update($validated);

        return new AccountCashlessResource($accountCashless);
    }

    public function destroy(
        Request $request,
        AccountCashless $accountCashless
    ): Response {
        $this->authorize('delete', $accountCashless);

        $accountCashless->delete();

        return response()->noContent();
    }
}
