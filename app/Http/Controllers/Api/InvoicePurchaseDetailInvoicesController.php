<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\InvoicePurchase;
use App\Http\Controllers\Controller;
use App\Http\Resources\DetailInvoiceResource;
use App\Http\Resources\DetailInvoiceCollection;

class InvoicePurchaseDetailInvoicesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\InvoicePurchase $invoicePurchase
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, InvoicePurchase $invoicePurchase)
    {
        $this->authorize('view', $invoicePurchase);

        $search = $request->get('search', '');

        $detailInvoices = $invoicePurchase
            ->detailInvoices()
            ->search($search)
            ->latest()
            ->paginate();

        return new DetailInvoiceCollection($detailInvoices);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\InvoicePurchase $invoicePurchase
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, InvoicePurchase $invoicePurchase)
    {
        $this->authorize('create', DetailInvoice::class);

        $validated = $request->validate([
            'quantity_product' => ['required', 'numeric'],
            'quantity_invoice' => ['required', 'numeric'],
            'unit_invoice_id' => ['required', 'exists:units,id'],
            'subtotal_invoice' => ['required', 'max:255'],
            'status' => ['required', 'max:255'],
        ]);

        $detailInvoice = $invoicePurchase->detailInvoices()->create($validated);

        return new DetailInvoiceResource($detailInvoice);
    }
}
