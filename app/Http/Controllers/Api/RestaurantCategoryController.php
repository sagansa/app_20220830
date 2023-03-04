<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\RestaurantCategory;
use App\Http\Controllers\Controller;
use App\Http\Resources\RestaurantCategoryResource;
use App\Http\Resources\RestaurantCategoryCollection;
use App\Http\Requests\RestaurantCategoryStoreRequest;
use App\Http\Requests\RestaurantCategoryUpdateRequest;

class RestaurantCategoryController extends Controller
{
    public function index(Request $request): RestaurantCategoryCollection
    {
        $this->authorize('view-any', RestaurantCategory::class);

        $search = $request->get('search', '');

        $restaurantCategories = RestaurantCategory::search($search)
            ->latest()
            ->paginate();

        return new RestaurantCategoryCollection($restaurantCategories);
    }

    public function store(
        RestaurantCategoryStoreRequest $request
    ): RestaurantCategoryResource {
        $this->authorize('create', RestaurantCategory::class);

        $validated = $request->validated();

        $restaurantCategory = RestaurantCategory::create($validated);

        return new RestaurantCategoryResource($restaurantCategory);
    }

    public function show(
        Request $request,
        RestaurantCategory $restaurantCategory
    ): RestaurantCategoryResource {
        $this->authorize('view', $restaurantCategory);

        return new RestaurantCategoryResource($restaurantCategory);
    }

    public function update(
        RestaurantCategoryUpdateRequest $request,
        RestaurantCategory $restaurantCategory
    ): RestaurantCategoryResource {
        $this->authorize('update', $restaurantCategory);

        $validated = $request->validated();

        $restaurantCategory->update($validated);

        return new RestaurantCategoryResource($restaurantCategory);
    }

    public function destroy(
        Request $request,
        RestaurantCategory $restaurantCategory
    ): Response {
        $this->authorize('delete', $restaurantCategory);

        $restaurantCategory->delete();

        return response()->noContent();
    }
}
