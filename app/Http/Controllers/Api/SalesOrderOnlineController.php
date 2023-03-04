<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\SalesOrderOnline;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\SalesOrderOnlineResource;
use App\Http\Resources\SalesOrderOnlineCollection;
use App\Http\Requests\SalesOrderOnlineStoreRequest;
use App\Http\Requests\SalesOrderOnlineUpdateRequest;

class SalesOrderOnlineController extends Controller
{
    public function index(Request $request): SalesOrderOnlineCollection
    {
        $this->authorize('view-any', SalesOrderOnline::class);

        $search = $request->get('search', '');

        $salesOrderOnlines = SalesOrderOnline::search($search)
            ->latest()
            ->paginate();

        return new SalesOrderOnlineCollection($salesOrderOnlines);
    }

    public function store(
        SalesOrderOnlineStoreRequest $request
    ): SalesOrderOnlineResource {
        $this->authorize('create', SalesOrderOnline::class);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        if ($request->hasFile('image_sent')) {
            $validated['image_sent'] = $request
                ->file('image_sent')
                ->store('public');
        }

        $salesOrderOnline = SalesOrderOnline::create($validated);

        return new SalesOrderOnlineResource($salesOrderOnline);
    }

    public function show(
        Request $request,
        SalesOrderOnline $salesOrderOnline
    ): SalesOrderOnlineResource {
        $this->authorize('view', $salesOrderOnline);

        return new SalesOrderOnlineResource($salesOrderOnline);
    }

    public function update(
        SalesOrderOnlineUpdateRequest $request,
        SalesOrderOnline $salesOrderOnline
    ): SalesOrderOnlineResource {
        $this->authorize('update', $salesOrderOnline);

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($salesOrderOnline->image) {
                Storage::delete($salesOrderOnline->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        if ($request->hasFile('image_sent')) {
            if ($salesOrderOnline->image_sent) {
                Storage::delete($salesOrderOnline->image_sent);
            }

            $validated['image_sent'] = $request
                ->file('image_sent')
                ->store('public');
        }

        $salesOrderOnline->update($validated);

        return new SalesOrderOnlineResource($salesOrderOnline);
    }

    public function destroy(
        Request $request,
        SalesOrderOnline $salesOrderOnline
    ): Response {
        $this->authorize('delete', $salesOrderOnline);

        if ($salesOrderOnline->image) {
            Storage::delete($salesOrderOnline->image);
        }

        if ($salesOrderOnline->image_sent) {
            Storage::delete($salesOrderOnline->image_sent);
        }

        $salesOrderOnline->delete();

        return response()->noContent();
    }
}
