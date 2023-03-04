<?php

namespace App\Http\Controllers\Api;

use App\Models\EProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SoDdetailResource;
use App\Http\Resources\SoDdetailCollection;

class EProductSoDdetailsController extends Controller
{
    public function index(
        Request $request,
        EProduct $eProduct
    ): SoDdetailCollection {
        $this->authorize('view', $eProduct);

        $search = $request->get('search', '');

        $soDdetails = $eProduct
            ->soDdetails()
            ->search($search)
            ->latest()
            ->paginate();

        return new SoDdetailCollection($soDdetails);
    }

    public function store(
        Request $request,
        EProduct $eProduct
    ): SoDdetailResource {
        $this->authorize('create', SoDdetail::class);

        $validated = $request->validate([
            'quantity' => ['required', 'numeric'],
            'price' => ['required', 'numeric'],
        ]);

        $soDdetail = $eProduct->soDdetails()->create($validated);

        return new SoDdetailResource($soDdetail);
    }
}
