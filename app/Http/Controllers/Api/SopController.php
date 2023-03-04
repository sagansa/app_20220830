<?php

namespace App\Http\Controllers\Api;

use App\Models\Sop;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\SopResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\SopCollection;
use App\Http\Requests\SopStoreRequest;
use App\Http\Requests\SopUpdateRequest;
use Illuminate\Support\Facades\Storage;

class SopController extends Controller
{
    public function index(Request $request): SopCollection
    {
        $this->authorize('view-any', Sop::class);

        $search = $request->get('search', '');

        $sops = Sop::search($search)
            ->latest()
            ->paginate();

        return new SopCollection($sops);
    }

    public function store(SopStoreRequest $request): SopResource
    {
        $this->authorize('create', Sop::class);

        $validated = $request->validated();
        if ($request->hasFile('file')) {
            $validated['file'] = $request->file('file')->store('public');
        }

        $sop = Sop::create($validated);

        return new SopResource($sop);
    }

    public function show(Request $request, Sop $sop): SopResource
    {
        $this->authorize('view', $sop);

        return new SopResource($sop);
    }

    public function update(SopUpdateRequest $request, Sop $sop): SopResource
    {
        $this->authorize('update', $sop);

        $validated = $request->validated();

        if ($request->hasFile('file')) {
            if ($sop->file) {
                Storage::delete($sop->file);
            }

            $validated['file'] = $request->file('file')->store('public');
        }

        $sop->update($validated);

        return new SopResource($sop);
    }

    public function destroy(Request $request, Sop $sop): Response
    {
        $this->authorize('delete', $sop);

        if ($sop->file) {
            Storage::delete($sop->file);
        }

        $sop->delete();

        return response()->noContent();
    }
}
