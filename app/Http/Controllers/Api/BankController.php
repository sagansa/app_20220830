<?php

namespace App\Http\Controllers\Api;

use App\Models\Bank;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\BankResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\BankCollection;
use App\Http\Requests\BankStoreRequest;
use App\Http\Requests\BankUpdateRequest;

class BankController extends Controller
{
    public function index(Request $request): BankCollection
    {
        $this->authorize('view-any', Bank::class);

        $search = $request->get('search', '');

        $banks = Bank::search($search)
            ->latest()
            ->paginate();

        return new BankCollection($banks);
    }

    public function store(BankStoreRequest $request): BankResource
    {
        $this->authorize('create', Bank::class);

        $validated = $request->validated();

        $bank = Bank::create($validated);

        return new BankResource($bank);
    }

    public function show(Request $request, Bank $bank): BankResource
    {
        $this->authorize('view', $bank);

        return new BankResource($bank);
    }

    public function update(BankUpdateRequest $request, Bank $bank): BankResource
    {
        $this->authorize('update', $bank);

        $validated = $request->validated();

        $bank->update($validated);

        return new BankResource($bank);
    }

    public function destroy(Request $request, Bank $bank): Response
    {
        $this->authorize('delete', $bank);

        $bank->delete();

        return response()->noContent();
    }
}
