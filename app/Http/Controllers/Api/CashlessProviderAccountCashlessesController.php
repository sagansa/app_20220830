<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\CashlessProvider;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\AccountCashlessResource;
use App\Http\Resources\AccountCashlessCollection;

class CashlessProviderAccountCashlessesController extends Controller
{
    public function index(
        Request $request,
        CashlessProvider $cashlessProvider
    ): AccountCashlessCollection {
        $this->authorize('view', $cashlessProvider);

        $search = $request->get('search', '');

        $accountCashlesses = $cashlessProvider
            ->accountCashlesses()
            ->search($search)
            ->latest()
            ->paginate();

        return new AccountCashlessCollection($accountCashlesses);
    }

    public function store(
        Request $request,
        CashlessProvider $cashlessProvider
    ): AccountCashlessResource {
        $this->authorize('create', AccountCashless::class);

        $validated = $request->validate([
            'store_id' => ['required', 'exists:stores,id'],
            'store_cashless_id' => ['required', 'exists:store_cashlesses,id'],
            'email' => ['nullable', 'email'],
            'username' => ['nullable', 'max:255', 'string'],
            'password' => ['nullable'],
            'no_telp' => ['nullable', 'string'],
            'status' => ['required', 'max:255'],
            'notes' => ['nullable', 'max:255', 'string'],
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $accountCashless = $cashlessProvider
            ->accountCashlesses()
            ->create($validated);

        return new AccountCashlessResource($accountCashless);
    }
}
