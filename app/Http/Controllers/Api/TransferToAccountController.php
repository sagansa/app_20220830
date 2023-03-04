<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\TransferToAccount;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransferToAccountResource;
use App\Http\Resources\TransferToAccountCollection;
use App\Http\Requests\TransferToAccountStoreRequest;
use App\Http\Requests\TransferToAccountUpdateRequest;

class TransferToAccountController extends Controller
{
    public function index(Request $request): TransferToAccountCollection
    {
        $this->authorize('view-any', TransferToAccount::class);

        $search = $request->get('search', '');

        $transferToAccounts = TransferToAccount::search($search)
            ->latest()
            ->paginate();

        return new TransferToAccountCollection($transferToAccounts);
    }

    public function store(
        TransferToAccountStoreRequest $request
    ): TransferToAccountResource {
        $this->authorize('create', TransferToAccount::class);

        $validated = $request->validated();

        $transferToAccount = TransferToAccount::create($validated);

        return new TransferToAccountResource($transferToAccount);
    }

    public function show(
        Request $request,
        TransferToAccount $transferToAccount
    ): TransferToAccountResource {
        $this->authorize('view', $transferToAccount);

        return new TransferToAccountResource($transferToAccount);
    }

    public function update(
        TransferToAccountUpdateRequest $request,
        TransferToAccount $transferToAccount
    ): TransferToAccountResource {
        $this->authorize('update', $transferToAccount);

        $validated = $request->validated();

        $transferToAccount->update($validated);

        return new TransferToAccountResource($transferToAccount);
    }

    public function destroy(
        Request $request,
        TransferToAccount $transferToAccount
    ): Response {
        $this->authorize('delete', $transferToAccount);

        $transferToAccount->delete();

        return response()->noContent();
    }
}
