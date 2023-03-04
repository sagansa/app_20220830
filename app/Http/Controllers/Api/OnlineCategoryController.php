<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\OnlineCategory;
use App\Http\Controllers\Controller;
use App\Http\Resources\OnlineCategoryResource;
use App\Http\Resources\OnlineCategoryCollection;
use App\Http\Requests\OnlineCategoryStoreRequest;
use App\Http\Requests\OnlineCategoryUpdateRequest;

class OnlineCategoryController extends Controller
{
    public function index(Request $request): OnlineCategoryCollection
    {
        $this->authorize('view-any', OnlineCategory::class);

        $search = $request->get('search', '');

        $onlineCategories = OnlineCategory::search($search)
            ->latest()
            ->paginate();

        return new OnlineCategoryCollection($onlineCategories);
    }

    public function store(
        OnlineCategoryStoreRequest $request
    ): OnlineCategoryResource {
        $this->authorize('create', OnlineCategory::class);

        $validated = $request->validated();

        $onlineCategory = OnlineCategory::create($validated);

        return new OnlineCategoryResource($onlineCategory);
    }

    public function show(
        Request $request,
        OnlineCategory $onlineCategory
    ): OnlineCategoryResource {
        $this->authorize('view', $onlineCategory);

        return new OnlineCategoryResource($onlineCategory);
    }

    public function update(
        OnlineCategoryUpdateRequest $request,
        OnlineCategory $onlineCategory
    ): OnlineCategoryResource {
        $this->authorize('update', $onlineCategory);

        $validated = $request->validated();

        $onlineCategory->update($validated);

        return new OnlineCategoryResource($onlineCategory);
    }

    public function destroy(
        Request $request,
        OnlineCategory $onlineCategory
    ): Response {
        $this->authorize('delete', $onlineCategory);

        $onlineCategory->delete();

        return response()->noContent();
    }
}
