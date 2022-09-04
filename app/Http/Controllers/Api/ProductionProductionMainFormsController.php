<?php

namespace App\Http\Controllers\Api;

use App\Models\Production;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductionMainFormResource;
use App\Http\Resources\ProductionMainFormCollection;

class ProductionProductionMainFormsController extends Controller
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

        $productionMainForms = $production
            ->productionMainForms()
            ->search($search)
            ->latest()
            ->paginate();

        return new ProductionMainFormCollection($productionMainForms);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Production $production
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Production $production)
    {
        $this->authorize('create', ProductionMainForm::class);

        $validated = $request->validate([
            'detail_invoice_id' => ['required', 'exists:detail_invoices,id'],
        ]);

        $productionMainForm = $production
            ->productionMainForms()
            ->create($validated);

        return new ProductionMainFormResource($productionMainForm);
    }
}
