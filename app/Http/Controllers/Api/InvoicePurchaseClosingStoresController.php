<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\ClosingStore;
use Illuminate\Http\Response;
use App\Models\InvoicePurchase;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClosingStoreCollection;

class InvoicePurchaseClosingStoresController extends Controller
{
    public function index(
        Request $request,
        InvoicePurchase $invoicePurchase
    ): ClosingStoreCollection {
        $this->authorize('view', $invoicePurchase);

        $search = $request->get('search', '');

        $closingStores = $invoicePurchase
            ->closingStores()
            ->search($search)
            ->latest()
            ->paginate();

        return new ClosingStoreCollection($closingStores);
    }

    public function store(
        Request $request,
        InvoicePurchase $invoicePurchase,
        ClosingStore $closingStore
    ): Response {
        $this->authorize('update', $invoicePurchase);

        $invoicePurchase
            ->closingStores()
            ->syncWithoutDetaching([$closingStore->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        InvoicePurchase $invoicePurchase,
        ClosingStore $closingStore
    ): Response {
        $this->authorize('update', $invoicePurchase);

        $invoicePurchase->closingStores()->detach($closingStore);

        return response()->noContent();
    }
}
