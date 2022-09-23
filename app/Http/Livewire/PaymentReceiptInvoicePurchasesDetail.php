<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\PaymentReceipt;
use App\Models\InvoicePurchase;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PaymentReceiptInvoicePurchasesDetail extends Component
{
    public $state = [];

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
        $this->invoicePurchasesForSelect = InvoicePurchase::orderBy('date', 'desc')
            ->where('payment_status', '=', '1')
            ->where('payment_type_id', '=', '1')
            ->get()
            ->pluck('id', 'invoice_purchase_name');
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
            ->attach($this->invoice_purchase_id, []);

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
        $this->subtotal = 0;
        $this->totals = 0;

        foreach ($this->paymentReceiptInvoicePurchases as $invoicePurchase) {
            foreach($$invoicePurchase->detailInvoices as $detailInvoice) {
                $this->subtotal += $detailInvoice->subtotal_invoice;
            }
            $this->totals = $this->subtotal - $invoicePurchase->discounts + $invoicePurchase->taxes;
        }

        $this->difference = $this->paymentReceipt->amount - $this->totals;

        return view('livewire.payment-receipt-invoice-purchases-detail', [
            'paymentReceiptInvoicePurchases' => $this->paymentReceipt
                ->invoicePurchases()
                ->withPivot([])
                ->paginate(20),
        ]);
    }

    public function changePaymentStatus(InvoicePurchase $invoicePurchase, $paymentStatus)
    {
        Validator::make(['payment_status' => $paymentStatus], [
			'payment_status' => [
				'required',
				Rule::in(InvoicePurchase::STATUS_BELUM_DIBAYAR, InvoicePurchase::STATUS_SUDAH_DIBAYAR),
			],
		])->validate();

		$invoicePurchase->update(['payment_status' => $paymentStatus]);

		$this->dispatchBrowserEvent('updated', ['message' => "Status changed to {$paymentStatus} successfully."]);
    }

    public function updatePaymentReceipt()
    {
        Validator::make(
            $this->state,
            [
                'amount' => 'required', 'numeric', 'min:0'
            ]
        )->validate();

        $this->paymentReceipt->update($this->state);
    }
}
