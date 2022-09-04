<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\ClosingStore;
use App\Models\InvoicePurchase;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClosingStoreCollection;

class InvoicePurchaseClosingStoresController extends Controller
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

        $closingStores = $invoicePurchase
            ->closingStores()
            ->search($search)
            ->latest()
            ->paginate();

        return new ClosingStoreCollection($closingStores);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\InvoicePurchase $invoicePurchase
     * @param \App\Models\ClosingStore $closingStore
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        InvoicePurchase $invoicePurchase,
        ClosingStore $closingStore
    ) {
        $this->authorize('update', $invoicePurchase);

        $invoicePurchase
            ->closingStores()
            ->syncWithoutDetaching([$closingStore->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\InvoicePurchase $invoicePurchase
     * @param \App\Models\ClosingStore $closingStore
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        InvoicePurchase $invoicePurchase,
        ClosingStore $closingStore
    ) {
        $this->authorize('update', $invoicePurchase);

        $invoicePurchase->closingStores()->detach($closingStore);

        return response()->noContent();
    }
}
