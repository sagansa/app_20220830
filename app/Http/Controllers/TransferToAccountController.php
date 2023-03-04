<?php

namespace App\Http\Controllers;

use Image;
use App\Models\Bank;
use Illuminate\Http\Request;
use App\Models\TransferToAccount;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\TransferToAccountStoreRequest;
use App\Http\Requests\TransferToAccountUpdateRequest;

class TransferToAccountController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', TransferToAccount::class);

        $search = $request->get('search', '');

        $transferToAccounts = TransferToAccount::search($search)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'app.transfer_to_accounts.index',
            compact('transferToAccounts', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $banks = Bank::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');

        return view('app.transfer_to_accounts.create', compact('banks'));
    }

    /**
     * @param \App\Http\Requests\TransferToAccountStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(TransferToAccountStoreRequest $request)
    {
        $this->authorize('create', TransferToAccount::class);

        $validated = $request->validated();

        $validated['created_by_id'] = auth()->user()->id;
        $validated['status'] = '1';

        $transferToAccount = TransferToAccount::create($validated);

        return redirect()
            ->route('transfer-to-accounts.edit', $transferToAccount)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\TransferToAccount $transferToAccount
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, TransferToAccount $transferToAccount)
    {
        $this->authorize('view', $transferToAccount);

        return view(
            'app.transfer_to_accounts.show',
            compact('transferToAccount')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\TransferToAccount $transferToAccount
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, TransferToAccount $transferToAccount)
    {
        $this->authorize('update', $transferToAccount);

        $banks = Bank::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');

        return view(
            'app.transfer_to_accounts.edit',
            compact('transferToAccount', 'banks')
        );
    }

    /**
     * @param \App\Http\Requests\TransferToAccountUpdateRequest $request
     * @param \App\Models\TransferToAccount $transferToAccount
     * @return \Illuminate\Http\Response
     */
    public function update(
        TransferToAccountUpdateRequest $request,
        TransferToAccount $transferToAccount
    ) {
        $this->authorize('update', $transferToAccount);

        $validated = $request->validated();

        if (
            auth()
                ->user()
                ->hasRole('supervisor|manager|super-admin')
        ) {
            $validated['approved_by_id'] = auth()->user()->id;
        }

        $transferToAccount->update($validated);

        return redirect()
            ->route('transfer-to-accounts.index')
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\TransferToAccount $transferToAccount
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        TransferToAccount $transferToAccount
    ) {
        $this->authorize('delete', $transferToAccount);

        $transferToAccount->delete();

        return redirect()
            ->route('transfer-to-accounts.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
