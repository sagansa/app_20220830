<?php

namespace App\Http\Controllers\Api;

use App\Models\Unit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DetailInvoiceResource;
use App\Http\Resources\DetailInvoiceCollection;

class UnitDetailInvoicesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Unit $unit
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Unit $unit)
    {
        $this->authorize('view', $unit);

        $search = $request->get('search', '');

        $detailInvoices = $unit
            ->detailInvoices()
            ->search($search)
            ->latest()
            ->paginate();

        return new DetailInvoiceCollection($detailInvoices);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Unit $unit
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Unit $unit)
    {
        $this->authorize('create', DetailInvoice::class);

        $validated = $request->validate([
            'detail_request_id' => ['required', 'exists:detail_requests,id'],
            'quantity_product' => ['required', 'numeric'],
            'quantity_invoice' => ['required', 'numeric'],
            'subtotal_invoice' => ['required', 'numeric', 'gt:0'],
            'status' => ['required', 'max:255'],
        ]);

        $detailInvoice = $unit->detailInvoices()->create($validated);

        return new DetailInvoiceResource($detailInvoice);
    }
}
