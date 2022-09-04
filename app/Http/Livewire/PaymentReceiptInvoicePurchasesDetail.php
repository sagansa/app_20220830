<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\PaymentReceipt;
use App\Models\InvoicePurchase;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PaymentReceiptInvoicePurchasesDetail extends Component
{
    use AuthorizesRequests;

    public PaymentReceipt $paymentReceipt;
    public InvoicePurchase $invoicePurchase;
    public $invoicePurchasesForSelect = [];
    public $invoice_purchase_id = null;

    public $showingModal = false;
    public $modalTitle = 'New InvoicePurchase';

    protected $rules = [
        'invoice_purchase_id' => ['required', 'exists:invoice_purchases,id'],
    ];

    public function mount(PaymentReceipt $paymentReceipt)
    {
        $this->paymentReceipt = $paymentReceipt;
        $this->invoicePurchasesForSelect = InvoicePurchase::pluck(
            'image',
            'id'
        );
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
            'crud.payment_receipt_invoice_purchases.new_title'
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

        $this->paymentReceipt
            ->invoicePurchases()
            ->attach($this->invoicePurchase_id, []);

        $this->hideModal();
    }

    public function detach($invoicePurchase)
    {
        $this->authorize('delete-any', InvoicePurchase::class);

        $this->paymentReceipt->invoicePurchases()->detach($invoicePurchase);

        $this->resetInvoicePurchaseData();
    }

    public function render()
    {
        return view('livewire.payment-receipt-invoice-purchases-detail', [
            'paymentReceiptInvoicePurchases' => $this->paymentReceipt
                ->invoicePurchases()
                ->withPivot([])
                ->paginate(20),
        ]);
    }
}
