<?php

namespace App\Http\Controllers\Api;

use App\Models\Unit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DetailInvoiceResource;
use App\Http\Resources\DetailInvoiceCollection;

class UnitDetailInvoicesController extends Controller
{
    public function index(Request $request, Unit $unit): DetailInvoiceCollection
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

    public function store(Request $request, Unit $unit): DetailInvoiceResource
    {
        $this->authorize('create', DetailInvoice::class);

        $validated = $request->validate([
            'quantity_product' => ['required', 'numeric'],
            'quantity_invoice' => ['required', 'numeric'],
            'subtotal_invoice' => ['required', 'max:255'],
            'status' => ['required', 'max:255'],
        ]);

        $detailInvoice = $unit->detailInvoices()->create($validated);

        return new DetailInvoiceResource($detailInvoice);
    }
}
