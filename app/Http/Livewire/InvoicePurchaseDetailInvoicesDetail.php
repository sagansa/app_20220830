<?php

namespace App\Http\Livewire;

use App\Models\Unit;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\DetailInvoice;
use App\Models\DetailRequest;
use App\Models\InvoicePurchase;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;

class InvoicePurchaseDetailInvoicesDetail extends Component
{
    public $state = [];

    use WithPagination;
    use AuthorizesRequests;

    public InvoicePurchase $invoicePurchase;
    public DetailInvoice $detailInvoice;
    public $detailRequestsForSelect = [];
    public $unitsForSelect = [];

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New DetailInvoice';

    protected $rules = [
        'detailInvoice.detail_request_id' => [
            // 'nullable'
            'required',
            'exists:detail_requests,id',
        ],
        'detailInvoice.quantity_product' => ['required', 'numeric', 'gt:0'],
        'detailInvoice.quantity_invoice' => ['required', 'numeric', 'gt:0'],
        'detailInvoice.unit_invoice_id' => ['required', 'exists:units,id'],
        'detailInvoice.subtotal_invoice' => ['required', 'numeric', 'gt:0'],
        'detailInvoice.status' => ['required', 'in:1,2,3'],
    ];

    public function mount(InvoicePurchase $invoicePurchase)
    {
        $this->invoicePurchase = $invoicePurchase;

        if($this->invoicePurchase->payment_type_id == '2') {
            $this->detailRequestsForSelect = DetailRequest::join('request_purchases', 'request_purchases.id', '=', 'detail_requests.request_purchase_id')
                ->join('products', 'products.id', '=', 'detail_requests.product_id')
                ->where('products.payment_type_id', '=', '2')
                ->whereIn('detail_requests.status', ['4', '5'])
                ->where('request_purchases.store_id', '=', $this->invoicePurchase->store_id)
                ->get()->pluck('id', 'detail_request_name');
        } else {
            $this->detailRequestsForSelect = DetailRequest::join('request_purchases', 'request_purchases.id', '=', 'detail_requests.request_purchase_id')
                ->whereIn('detail_requests.status', ['4', '5'])
                ->where('request_purchases.store_id', '=', $this->invoicePurchase->store_id)
                ->get()->pluck('id', 'detail_request_name');
        }

        // $this->detailRequestsForSelect = DetailRequest::get()->pluck( 'id', 'detail_request_name');

        $this->unitsForSelect = Unit::orderBy('unit', 'asc')->pluck('id', 'unit');
        $this->resetDetailInvoiceData();

    }

    public function resetDetailInvoiceData()
    {
        $this->detailInvoice = new DetailInvoice();

        $this->detailInvoice->detail_request_id = null;
        $this->detailInvoice->unit_invoice_id = null;
        $this->detailInvoice->status = '1';

        $this->dispatchBrowserEvent('refresh');
    }

    public function newDetailInvoice()
    {
        $this->editing = false;
        $this->modalTitle = trans(
            'crud.invoice_purchase_detail_invoices.new_title'
        );
        $this->resetDetailInvoiceData();

        $this->showModal();
    }

    public function editDetailInvoice(DetailInvoice $detailInvoice)
    {
        $this->editing = true;
        $this->modalTitle = trans(
            'crud.invoice_purchase_detail_invoices.edit_title'
        );
        $this->detailInvoice = $detailInvoice;

        $this->dispatchBrowserEvent('refresh');

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

        if (!$this->detailInvoice->invoice_purchase_id) {
            $this->authorize('create', DetailInvoice::class);

            $this->detailInvoice->invoice_purchase_id =
                $this->invoicePurchase->id;
        } else {
            $this->authorize('update', $this->detailInvoice);
        }

        // dd($this->detailInvoice);

        $this->detailInvoice->save();

        $this->hideModal();
    }

    public function destroySelected()
    {
        $this->authorize('delete-any', DetailInvoice::class);

        DetailInvoice::whereIn('id', $this->selected)->delete();

        DetailRequest::whereIn('id', $this->detailInvoice)->update([
            'status' => '4',
        ]);

        $this->selected = [];
        $this->allSelected = false;

        $this->resetDetailInvoiceData();
    }

    public function toggleFullSelection()
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->invoicePurchase->detailInvoices as $detailInvoice) {
            array_push($this->selected, $detailInvoice->id);
        }
    }

    public function render()
    {
        $this->invoicePurchase->subtotals = 0;

        foreach ($this->invoicePurchase->detailInvoices as $detailInvoice) {
            $this->detailInvoice->subtotals += $detailInvoice['subtotal_invoice'];
        }

        $this->invoicePurchase->totals = $this->invoicePurchase->subtotals - $this->invoicePurchase->discounts + $this->invoicePurchase->taxes;

        return view('livewire.invoice-purchase-detail-invoices-detail', [
            'detailInvoices' => $this->invoicePurchase
                ->detailInvoices()
                ->paginate(20),
        ]);
    }

    public function updateInvoicePurchase()
    {
        Validator::make(
			$this->state,
			[
				'discounts' => 'required', 'numeric', 'min:0',
                'taxes' => 'required', 'numeric', 'min:0',

			])->validate();

		$this->invoicePurchase->update($this->state);
    }
}
