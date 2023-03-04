<?php

namespace App\Http\Controllers\Api;

use App\Models\ClosingStore;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CashlessResource;
use App\Http\Resources\CashlessCollection;

class ClosingStoreCashlessesController extends Controller
{
    public function index(
        Request $request,
        ClosingStore $closingStore
    ): CashlessCollection {
        $this->authorize('view', $closingStore);

        $search = $request->get('search', '');

        $cashlesses = $closingStore
            ->cashlesses()
            ->search($search)
            ->latest()
            ->paginate();

        return new CashlessCollection($cashlesses);
    }

    public function store(
        Request $request,
        ClosingStore $closingStore
    ): CashlessResource {
        $this->authorize('create', Cashless::class);

        $validated = $request->validate([
            'image' => ['nullable', 'image'],
            'account_cashless_id' => [
                'required',
                'exists:account_cashlesses,id',
            ],
            'bruto_apl' => ['required', 'numeric', 'min:0'],
            'netto_apl' => ['nullable', 'numeric', 'min:0'],
            'image_canceled' => ['image', 'nullable'],
            'canceled' => ['required', 'numeric', 'min:0'],
            'bruto_real' => ['nullable', 'numeric', 'min:0'],
            'netto_real' => ['nullable', 'numeric', 'min:0'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        if ($request->hasFile('image_canceled')) {
            $validated['image_canceled'] = $request
                ->file('image_canceled')
                ->store('public');
        }

        $cashless = $closingStore->cashlesses()->create($validated);

        return new CashlessResource($cashless);
    }
}
