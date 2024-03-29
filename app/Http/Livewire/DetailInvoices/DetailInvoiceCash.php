<?php

namespace App\Http\Livewire\DetailInvoices;

use App\Models\DetailInvoice;
use App\Models\DetailRequest;
use App\Models\InvoicePurchase;
use App\Models\Unit;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithPagination;

class DetailInvoiceCash extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public InvoicePurchase $invoicePurchase;
    public DetailInvoice $detailInvoice;
    public $detailRequestsForSelect = [];
    public $unitsForSelect = [];

    public $detailRequestsForCash = [];
    public $detailRequestsForTransfer = [];

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New Detail Invoice';

    protected $rules = [
        'detailInvoice.detail_request_id' => [
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

        $this->detailRequestsForSelect = DetailRequest::where('status', '4')
            ->orderBy('id', 'desc')
            ->where('store_id', $this->invoicePurchase->store_id)
            ->get()
            ->pluck('id', 'detail_request_name');

        $this->unitsForSelect = Unit::orderBy('unit', 'asc')->pluck('id', 'unit');
        $this->resetDetailInvoiceData();
    }

    public function resetDetailInvoiceData(): void
    {
        $this->detailInvoice = new DetailInvoice();

        $this->detailInvoice->detail_request_id = null;
        $this->detailInvoice->unit_invoice_id = null;
        $this->detailInvoice->status = '1';

        $this->dispatchBrowserEvent('refresh');
    }

    public function newDetailInvoice(): void
    {
        $this->editing = false;
        $this->modalTitle = trans(
            'crud.invoice_purchase_detail_invoices.new_title'
        );
        $this->resetDetailInvoiceData();

        $this->showModal();
    }

    public function editDetailInvoice(DetailInvoice $detailInvoice): void
    {
        $this->editing = true;
        $this->modalTitle = trans(
            'crud.invoice_purchase_detail_invoices.edit_title'
        );
        $this->detailInvoice = $detailInvoice;

        $this->dispatchBrowserEvent('refresh');

        $this->showModal();
    }

    public function showModal(): void
    {
        $this->resetErrorBag();
        $this->showingModal = true;
    }

    public function hideModal(): void
    {
        $this->showingModal = false;
    }

    public function save(): void
    {
        $this->validate();

        if (!$this->detailInvoice->invoice_purchase_id) {
            $this->authorize('create', DetailInvoice::class);

            $this->detailInvoice->invoice_purchase_id =
                $this->invoicePurchase->id;
        } else {
            $this->authorize('update', $this->detailInvoice);
        }

        DetailRequest::where('id', '=', $this->detailInvoice)->update([
            'status' => '2',
        ]);

        $this->detailInvoice->save();

        $this->hideModal();
    }

    public function destroySelected(): void
    {
        $this->authorize('delete-any', DetailInvoice::class);

        DetailInvoice::whereIn('id', $this->selected)->delete();

        DetailRequest::where('id', '=', $this->detailInvoice)->update([
            'status' => '4',
        ]);

        $this->selected = [];
        $this->allSelected = false;

        $this->resetDetailInvoiceData();
    }

    public function toggleFullSelection(): void
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

        $this->invoicePurchase->totals = $this->detailInvoice->subtotals - $this->invoicePurchase->discounts + $this->invoicePurchase->taxes;

        return view('livewire.detail-invoices.detail-invoice-cash', [
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
