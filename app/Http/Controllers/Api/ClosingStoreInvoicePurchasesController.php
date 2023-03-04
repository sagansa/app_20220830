<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\ClosingStore;
use Illuminate\Http\Response;
use App\Models\InvoicePurchase;
use App\Http\Controllers\Controller;
use App\Http\Resources\InvoicePurchaseCollection;

class ClosingStoreInvoicePurchasesController extends Controller
{
    public function index(
        Request $request,
        ClosingStore $closingStore
    ): InvoicePurchaseCollection {
        $this->authorize('view', $closingStore);

        $search = $request->get('search', '');

        $invoicePurchases = $closingStore
            ->invoicePurchases()
            ->search($search)
            ->latest()
            ->paginate();

        return new InvoicePurchaseCollection($invoicePurchases);
    }

    public function store(
        Request $request,
        ClosingStore $closingStore,
        InvoicePurchase $invoicePurchase
    ): Response {
        $this->authorize('update', $closingStore);

        $closingStore
            ->invoicePurchases()
            ->syncWithoutDetaching([$invoicePurchase->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        ClosingStore $closingStore,
        InvoicePurchase $invoicePurchase
    ): Response {
        $this->authorize('update', $closingStore);

        $closingStore->invoicePurchases()->detach($invoicePurchase);

        return response()->noContent();
    }
}
