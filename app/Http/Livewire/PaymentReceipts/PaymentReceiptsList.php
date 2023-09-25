<?php

namespace App\Http\Livewire\PaymentReceipts;

use App\Http\Livewire\DataTables\WithBulkAction;
use App\Http\Livewire\DataTables\WithCachedRows;
use App\Http\Livewire\DataTables\WithFilter;
use App\Http\Livewire\DataTables\WithModal;
use App\Http\Livewire\DataTables\WithPerPagePagination;
use App\Http\Livewire\DataTables\WithSorting;
use App\Models\PaymentReceipt;
use Livewire\Component;

class PaymentReceiptsList extends Component
{
    use WithPerPagePagination, WithSorting, WithModal, WithBulkAction, WithCachedRows, WithFilter;

    public PaymentReceipt $editing;

    public $sortColumn = 'payment_receipts.created_at';

    protected $queryString = [

    ];

    public $fiters = [
        'payment_for' => '',
    ];

    public function rules()
    {
        return [
            'editing.payment_for' => 'required|in:1,2,3',
        ];
    }

    public function getRowsQueryProperty()
    {
        $paymentReceipts = PaymentReceipt::query()
            ->latest();

        foreach ($this->filters as $filter => $value) {
            if (!empty($value)) {
                $paymentReceipts
                    ->when($filter == 'payment_for', fn($paymentReceipts) => $paymentReceipts->where('payment_receipts.' . $filter, 'LIKE', '%' . $value . '%'));
            }
        }

        foreach($paymentReceipts as $paymentReceipt) {
            foreach($paymentReceipt->invoicePurchases as $invoicePurchase) {
                $invoicePurchase->subtotals += $invoicePurchase->detailInvoices->sum('subtotal_invoice') - $invoicePurchase->discounts + $invoicePurchase->taxes;
            }

            $paymentReceipt->totals += $invoicePurchase->subtotals;
        }

        return $this->applySorting($paymentReceipts);
    }

    public function render()
    {
        // $paymentReceipts = PaymentReceipt::query()->latest();

        // foreach($paymentReceipts as $paymentReceipt) {
        //     foreach($paymentReceipt->invoicePurchases as $invoicePurchase) {
        //         $invoicePurchase->subtotals += $invoicePurchase->detailInvoices->sum('subtotal_invoice') - $invoicePurchase->discounts + $invoicePurchase->taxes;
        //     }

        //     $paymentReceipt->totals += $invoicePurchase->subtotals;
        // }

        return view('livewire.payment-receipts.payment-receipts-list', [
            // 'paymentReceipts' => $paymentReceipts->paginate(10),
            'paymentReceipts' => $this->rows,
        ]);
    }
}
