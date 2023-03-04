<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\SalesOrderDirect;
use App\Http\Controllers\Controller;
use App\Http\Resources\SoDdetailResource;
use App\Http\Resources\SoDdetailCollection;

class SalesOrderDirectSoDdetailsController extends Controller
{
    public function index(
        Request $request,
        SalesOrderDirect $salesOrderDirect
    ): SoDdetailCollection {
        $this->authorize('view', $salesOrderDirect);

        $search = $request->get('search', '');

        $soDdetails = $salesOrderDirect
            ->soDdetails()
            ->search($search)
            ->latest()
            ->paginate();

        return new SoDdetailCollection($soDdetails);
    }

    public function store(
        Request $request,
        SalesOrderDirect $salesOrderDirect
    ): SoDdetailResource {
        $this->authorize('create', SoDdetail::class);

        $validated = $request->validate([
            'e_product_id' => ['required', 'exists:e_products,id'],
            'quantity' => ['required', 'numeric'],
            'price' => ['required', 'numeric'],
        ]);

        $soDdetail = $salesOrderDirect->soDdetails()->create($validated);

        return new SoDdetailResource($soDdetail);
    }
}
