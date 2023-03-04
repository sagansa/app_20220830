<?php

namespace App\Http\Controllers\Api;

use App\Models\Refund;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\RefundResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\RefundCollection;
use App\Http\Requests\RefundStoreRequest;
use App\Http\Requests\RefundUpdateRequest;

class RefundController extends Controller
{
    public function index(Request $request): RefundCollection
    {
        $this->authorize('view-any', Refund::class);

        $search = $request->get('search', '');

        $refunds = Refund::search($search)
            ->latest()
            ->paginate();

        return new RefundCollection($refunds);
    }

    public function store(RefundStoreRequest $request): RefundResource
    {
        $this->authorize('create', Refund::class);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $refund = Refund::create($validated);

        return new RefundResource($refund);
    }

    public function show(Request $request, Refund $refund): RefundResource
    {
        $this->authorize('view', $refund);

        return new RefundResource($refund);
    }

    public function update(
        RefundUpdateRequest $request,
        Refund $refund
    ): RefundResource {
        $this->authorize('update', $refund);

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($refund->image) {
                Storage::delete($refund->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        $refund->update($validated);

        return new RefundResource($refund);
    }

    public function destroy(Request $request, Refund $refund): Response
    {
        $this->authorize('delete', $refund);

        if ($refund->image) {
            Storage::delete($refund->image);
        }

        $refund->delete();

        return response()->noContent();
    }
}
