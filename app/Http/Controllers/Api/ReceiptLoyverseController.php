<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\ReceiptLoyverse;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReceiptLoyverseResource;
use App\Http\Resources\ReceiptLoyverseCollection;
use App\Http\Requests\ReceiptLoyverseStoreRequest;
use App\Http\Requests\ReceiptLoyverseUpdateRequest;

class ReceiptLoyverseController extends Controller
{
    public function index(Request $request): ReceiptLoyverseCollection
    {
        $this->authorize('view-any', ReceiptLoyverse::class);

        $search = $request->get('search', '');

        $receiptLoyverses = ReceiptLoyverse::search($search)
            ->latest()
            ->paginate();

        return new ReceiptLoyverseCollection($receiptLoyverses);
    }

    public function store(
        ReceiptLoyverseStoreRequest $request
    ): ReceiptLoyverseResource {
        $this->authorize('create', ReceiptLoyverse::class);

        $validated = $request->validated();

        $receiptLoyverse = ReceiptLoyverse::create($validated);

        return new ReceiptLoyverseResource($receiptLoyverse);
    }

    public function show(
        Request $request,
        ReceiptLoyverse $receiptLoyverse
    ): ReceiptLoyverseResource {
        $this->authorize('view', $receiptLoyverse);

        return new ReceiptLoyverseResource($receiptLoyverse);
    }

    public function update(
        ReceiptLoyverseUpdateRequest $request,
        ReceiptLoyverse $receiptLoyverse
    ): ReceiptLoyverseResource {
        $this->authorize('update', $receiptLoyverse);

        $validated = $request->validated();

        $receiptLoyverse->update($validated);

        return new ReceiptLoyverseResource($receiptLoyverse);
    }

    public function destroy(
        Request $request,
        ReceiptLoyverse $receiptLoyverse
    ): Response {
        $this->authorize('delete', $receiptLoyverse);

        $receiptLoyverse->delete();

        return response()->noContent();
    }
}
