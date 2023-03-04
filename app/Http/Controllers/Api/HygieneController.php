<?php

namespace App\Http\Controllers\Api;

use App\Models\Hygiene;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\HygieneResource;
use App\Http\Resources\HygieneCollection;
use App\Http\Requests\HygieneStoreRequest;
use App\Http\Requests\HygieneUpdateRequest;

class HygieneController extends Controller
{
    public function index(Request $request): HygieneCollection
    {
        $this->authorize('view-any', Hygiene::class);

        $search = $request->get('search', '');

        $hygienes = Hygiene::search($search)
            ->latest()
            ->paginate();

        return new HygieneCollection($hygienes);
    }

    public function store(HygieneStoreRequest $request): HygieneResource
    {
        $this->authorize('create', Hygiene::class);

        $validated = $request->validated();

        $hygiene = Hygiene::create($validated);

        return new HygieneResource($hygiene);
    }

    public function show(Request $request, Hygiene $hygiene): HygieneResource
    {
        $this->authorize('view', $hygiene);

        return new HygieneResource($hygiene);
    }

    public function update(
        HygieneUpdateRequest $request,
        Hygiene $hygiene
    ): HygieneResource {
        $this->authorize('update', $hygiene);

        $validated = $request->validated();

        $hygiene->update($validated);

        return new HygieneResource($hygiene);
    }

    public function destroy(Request $request, Hygiene $hygiene): Response
    {
        $this->authorize('delete', $hygiene);

        $hygiene->delete();

        return response()->noContent();
    }
}
