<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\ReceiptByItemLoyverse;
use App\Http\Resources\ReceiptByItemLoyverseResource;
use App\Http\Resources\ReceiptByItemLoyverseCollection;
use App\Http\Requests\ReceiptByItemLoyverseStoreRequest;
use App\Http\Requests\ReceiptByItemLoyverseUpdateRequest;

class ReceiptByItemLoyverseController extends Controller
{
    public function index(Request $request): ReceiptByItemLoyverseCollection
    {
        $this->authorize('view-any', ReceiptByItemLoyverse::class);

        $search = $request->get('search', '');

        $receiptByItemLoyverses = ReceiptByItemLoyverse::search($search)
            ->latest()
            ->paginate();

        return new ReceiptByItemLoyverseCollection($receiptByItemLoyverses);
    }

    public function store(
        ReceiptByItemLoyverseStoreRequest $request
    ): ReceiptByItemLoyverseResource {
        $this->authorize('create', ReceiptByItemLoyverse::class);

        $validated = $request->validated();

        $receiptByItemLoyverse = ReceiptByItemLoyverse::create($validated);

        return new ReceiptByItemLoyverseResource($receiptByItemLoyverse);
    }

    public function show(
        Request $request,
        ReceiptByItemLoyverse $receiptByItemLoyverse
    ): ReceiptByItemLoyverseResource {
        $this->authorize('view', $receiptByItemLoyverse);

        return new ReceiptByItemLoyverseResource($receiptByItemLoyverse);
    }

    public function update(
        ReceiptByItemLoyverseUpdateRequest $request,
        ReceiptByItemLoyverse $receiptByItemLoyverse
    ): ReceiptByItemLoyverseResource {
        $this->authorize('update', $receiptByItemLoyverse);

        $validated = $request->validated();

        $receiptByItemLoyverse->update($validated);

        return new ReceiptByItemLoyverseResource($receiptByItemLoyverse);
    }

    public function destroy(
        Request $request,
        ReceiptByItemLoyverse $receiptByItemLoyverse
    ): Response {
        $this->authorize('delete', $receiptByItemLoyverse);

        $receiptByItemLoyverse->delete();

        return response()->noContent();
    }
}
