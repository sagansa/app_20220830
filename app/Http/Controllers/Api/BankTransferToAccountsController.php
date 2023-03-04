<?php

namespace App\Http\Controllers\Api;

use App\Models\Bank;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransferToAccountResource;
use App\Http\Resources\TransferToAccountCollection;

class BankTransferToAccountsController extends Controller
{
    public function index(
        Request $request,
        Bank $bank
    ): TransferToAccountCollection {
        $this->authorize('view', $bank);

        $search = $request->get('search', '');

        $transferToAccounts = $bank
            ->transferToAccounts()
            ->search($search)
            ->latest()
            ->paginate();

        return new TransferToAccountCollection($transferToAccounts);
    }

    public function store(
        Request $request,
        Bank $bank
    ): TransferToAccountResource {
        $this->authorize('create', TransferToAccount::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'number' => ['required', 'max:255'],
            'status' => ['required', 'max:255'],
        ]);

        $transferToAccount = $bank->transferToAccounts()->create($validated);

        return new TransferToAccountResource($transferToAccount);
    }
}
