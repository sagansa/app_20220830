<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\ClosingStore;
use App\Models\InvoicePurchase;
use App\Http\Controllers\Controller;
use App\Http\Resources\InvoicePurchaseCollection;

class ClosingStoreInvoicePurchasesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ClosingStore $closingStore
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, ClosingStore $closingStore)
    {
        $this->authorize('view', $closingStore);

        $search = $request->get('search', '');

        $invoicePurchases = $closingStore
            ->invoicePurchases()
            ->search($search)
            ->latest()
            ->paginate();

        return new InvoicePurchaseCollection($invoicePurchases);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ClosingStore $closingStore
     * @param \App\Models\InvoicePurchase $invoicePurchase
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        ClosingStore $closingStore,
        InvoicePurchase $invoicePurchase
    ) {
        $this->authorize('update', $closingStore);

        $closingStore
            ->invoicePurchases()
            ->syncWithoutDetaching([$invoicePurchase->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ClosingStore $closingStore
     * @param \App\Models\InvoicePurchase $invoicePurchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        ClosingStore $closingStore,
        InvoicePurchase $invoicePurchase
    ) {
        $this->authorize('update', $closingStore);

        $closingStore->invoicePurchases()->detach($invoicePurchase);

        return response()->noContent();
    }
}
