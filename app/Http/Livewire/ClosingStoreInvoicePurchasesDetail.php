<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ClosingStore;
use App\Models\InvoicePurchase;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ClosingStoreInvoicePurchasesDetail extends Component
{
    use AuthorizesRequests;

    public ClosingStore $closingStore;
    public InvoicePurchase $invoicePurchase;
    public $invoicePurchasesForSelect = [];
    public $invoice_purchase_id = null;

    public $showingModal = false;
    public $modalTitle = 'New InvoicePurchase';

    protected $rules = [
        'invoice_purchase_id' => ['required', 'exists:invoice_purchases,id'],
    ];

    public function mount(ClosingStore $closingStore)
    {
        $this->closingStore = $closingStore;
        $this->invoicePurchasesForSelect = InvoicePurchase::where('store_id', $this->closingStore->store_id)
            ->join('suppliers', 'suppliers.id', '=', 'invoice_purchases.supplier_id')
            ->select('invoice_purchases.*', 'suppliers.*')
            ->whereIn('invoice_purchases.payment_type_id', ['2'])
            ->whereIn('invoice_purchases.payment_status', ['1', '3'])
            ->get()
            ->pluck('supplier_id','id');
        $this->resetInvoicePurchaseData();
    }

    public function resetInvoicePurchaseData()
    {
        $this->invoicePurchase = new InvoicePurchase();

        $this->invoice_purchase_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newInvoicePurchase()
    {
        $this->modalTitle = trans(
            'crud.closing_store_invoice_purchases.new_title'
        );
        $this->resetInvoicePurchaseData();

        $this->showModal();
    }

    public function showModal()
    {
        $this->resetErrorBag();
        $this->showingModal = true;
    }

    public function hideModal()
    {
        $this->showingModal = false;
    }

    public function save()
    {
        $this->validate();

        $this->authorize('create', InvoicePurchase::class);

        $this->closingStore
            ->invoicePurchases()
            ->attach($this->invoice_purchase_id, []);

        $this->hideModal();
    }

    public function detach($invoicePurchase)
    {
        // $this->authorize('delete-any', InvoicePurchase::class);

        $this->closingStore->invoicePurchases()->detach($invoicePurchase);

        $this->resetInvoicePurchaseData();
    }

    public function render()
    {
        $this->subtotal = 0;
        $this->totals = 0;

        foreach ($this->closingStore->invoicePurchases as $invoicePurchase) {
            foreach ($invoicePurchase->detailInvoices as $detailInvoice) {
                $this->subtotal += $detailInvoice['subtotal_invoice'];
            }

            $this->totals = $this->subtotal - $invoicePurchase['discounts'] + $invoicePurchase['taxes'];
        }

        return view('livewire.closing-store-invoice-purchases-detail', [
            'closingStoreInvoicePurchases' => $this->closingStore
                ->invoicePurchases()
                ->withPivot([])
                ->paginate(20),
        ]);
    }
}
