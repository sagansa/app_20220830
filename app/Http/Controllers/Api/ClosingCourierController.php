<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\ClosingCourier;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\ClosingCourierResource;
use App\Http\Resources\ClosingCourierCollection;
use App\Http\Requests\ClosingCourierStoreRequest;
use App\Http\Requests\ClosingCourierUpdateRequest;

class ClosingCourierController extends Controller
{
    public function index(Request $request): ClosingCourierCollection
    {
        $this->authorize('view-any', ClosingCourier::class);

        $search = $request->get('search', '');

        $closingCouriers = ClosingCourier::search($search)
            ->latest()
            ->paginate();

        return new ClosingCourierCollection($closingCouriers);
    }

    public function store(
        ClosingCourierStoreRequest $request
    ): ClosingCourierResource {
        $this->authorize('create', ClosingCourier::class);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $closingCourier = ClosingCourier::create($validated);

        return new ClosingCourierResource($closingCourier);
    }

    public function show(
        Request $request,
        ClosingCourier $closingCourier
    ): ClosingCourierResource {
        $this->authorize('view', $closingCourier);

        return new ClosingCourierResource($closingCourier);
    }

    public function update(
        ClosingCourierUpdateRequest $request,
        ClosingCourier $closingCourier
    ): ClosingCourierResource {
        $this->authorize('update', $closingCourier);

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($closingCourier->image) {
                Storage::delete($closingCourier->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        $closingCourier->update($validated);

        return new ClosingCourierResource($closingCourier);
    }

    public function destroy(
        Request $request,
        ClosingCourier $closingCourier
    ): Response {
        $this->authorize('delete', $closingCourier);

        if ($closingCourier->image) {
            Storage::delete($closingCourier->image);
        }

        $closingCourier->delete();

        return response()->noContent();
    }
}
