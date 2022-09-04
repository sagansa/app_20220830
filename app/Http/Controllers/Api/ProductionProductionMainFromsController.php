<?php

namespace App\Http\Controllers\Api;

use App\Models\Production;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductionMainFromResource;
use App\Http\Resources\ProductionMainFromCollection;

class ProductionProductionMainFromsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Production $production
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Production $production)
    {
        $this->authorize('view', $production);

        $search = $request->get('search', '');

        $productionMainFroms = $production
            ->productionMainFroms()
            ->search($search)
            ->latest()
            ->paginate();

        return new ProductionMainFromCollection($productionMainFroms);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Production $production
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Production $production)
    {
        $this->authorize('create', ProductionMainFrom::class);

        $validated = $request->validate([
            'detail_invoice_id' => ['required', 'exists:detail_invoices,id'],
        ]);

        $productionMainFrom = $production
            ->productionMainFroms()
            ->create($validated);

        return new ProductionMainFromResource($productionMainFrom);
    }
}
