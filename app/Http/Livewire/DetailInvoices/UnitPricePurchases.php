<?php

namespace App\Http\Livewire\DetailInvoices;

use App\Http\Livewire\DataTables\WithBulkAction;
use App\Http\Livewire\DataTables\WithCachedRows;
use App\Http\Livewire\DataTables\WithFilter;
use App\Http\Livewire\DataTables\WithModal;
use App\Http\Livewire\DataTables\WithPerPagePagination;
use App\Http\Livewire\DataTables\WithSortingDate;
use App\Models\DetailInvoice;
use App\Models\DetailRequest;
use App\Models\InvoicePurchase;
use App\Models\Product;
use App\Models\Store;
use App\Models\Supplier;
use App\Models\Unit;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithPagination;

class UnitPricePurchases extends Component
{
    use WithPerPagePagination, WithSortingDate, WithModal, WithBulkAction, WithCachedRows, WithFilter;

    use WithPagination;
    use AuthorizesRequests;

    public $detailRequestsForSelect = [];
    public $unitsForSelect = [];

    public $suppliers;
    public $stores;
    public $products;

    public InvoicePurchase $invoicePurchase;
    public DetailInvoice $detailInvoice;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New Detail Invoice';

    public $sortColumn = 'detail_invoices.created_at';

    protected $queryString = [
        'sortColumn' => [
        'except' => 'detail_invoices.created_at'
        ],
        'sortDirection' => [
            'except' => 'desc',
        ],
    ];

    public $filters = [
        'product_id' => null,
        'supplier_id' => null,
        'store_id' => null,
    ];

    protected $rules = [
        'editing.detail_request_id' => [
            'required',
            'exists:detail_requests,id',
        ],
        'editing.quantity_product' => ['required', 'numeric', 'gt:0'],
        'editing.quantity_invoice' => ['required', 'numeric', 'gt:0'],
        'editing.unit_invoice_id' => ['required', 'exists:units,id'],
        'editing.subtotal_invoice' => ['required', 'numeric', 'gt:0'],
        'editing.status' => ['required', 'in:1,2,3'],
    ];

    public function mount()
    {
        $this->suppliers = Supplier::orderBy('name', 'asc')->pluck('id', 'name');
        $this->stores = Store::orderBy('nickname', 'asc')->pluck('id', 'nickname');
        $this->products = Product::orderBy('name', 'asc')
            ->whereNotIn('material_group_id', ['2', '6'])
            ->pluck('id', 'name');

        // $this->detailRequestsForSelect = DetailRequest::where('status', '4')
        //     ->orderBy('id', 'desc')
        //     ->where('store_id', $this->invoicePurchase->store_id)
        //     ->get()
        //     ->pluck('id', 'detail_request_name');

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

        $this->authorize('update', $this->detailInvoice);

        DetailRequest::where('id', '=', $this->detailInvoice)->update([
            'status' => '2',
        ]);

        $this->detailInvoice->save();

        $this->hideModal();
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

    public function getRowsQueryProperty()
    {
        $detailInvoices = DetailInvoice::query();

            foreach ($this->filters as $filter => $value) {
                if (!empty($value)) {
                    $detailInvoices
                        ->when($filter == 'store_id', fn($detailInvoices) => $detailInvoices->whereRelation('invoicePurchase.store', 'id', $value))
                        ->when($filter == 'supplier_id', fn($detailInvoices) => $detailInvoices->whereRelation('invoicePurchase.supplier', 'id', $value))
                        ->when($filter == 'product_id', fn($detailInvoices) => $detailInvoices->whereRelation('detailRequest.product', 'id', $value));
                }
            }

        return $this->applySorting($detailInvoices);
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function render()
    {
        return view('livewire.detail-invoices.unit-price-purchases', [
            'detailInvoices' => DetailInvoice::paginate(20),
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
