<?php

namespace App\Http\Livewire\DetailInvoices;

use App\Http\Livewire\DataTables\WithBulkAction;
use App\Http\Livewire\DataTables\WithCachedRows;
use App\Http\Livewire\DataTables\WithFilter;
use App\Http\Livewire\DataTables\WithModal;
use App\Http\Livewire\DataTables\WithSimpleTablePagination;
use App\Http\Livewire\DataTables\WithSorting;
use App\Models\DetailInvoice;
use App\Models\Product;
use App\Models\Store;
use App\Models\Supplier;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Livewire\Component;

class UnitPricePurchases extends Component
{
    use WithSimpleTablePagination, WithSorting, WithModal, WithBulkAction, WithCachedRows, WithFilter;

    public DetailInvoice $editing;

    public $sortColumn = 'detail_invoices.created_at';

    protected $queryString = [
        'sortColumn' => [
        'except' => 'detail_invoices.created_at'
        ],
        'sortDirection' => [
            'except' => 'asc',
        ],
    ];

    public $filters = [
        'status' => '',
        'store_id' => null,
        'supplier_id' => null,
        'product_id' => null,
    ];

    public function mount()
    {
        $this->suppliers = Supplier::orderBy('name', 'asc')->pluck('id', 'name');
        $this->stores = Store::orderBy('nickname', 'asc')->pluck('id', 'nickname');
        $this->products = Product::orderBy('name', 'asc')->pluck('id', 'name');
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
            'detailInvoices' => $this->rows,
        ]);
    }

     public function changeStatus(DetailInvoice $detailInvoice, $status)
    {
        Validator::make(['status' => $status], [
			'status' => [
				'required',
				Rule::in(DetailInvoice::STATUS_PROCESS, DetailInvoice::STATUS_DONE, DetailInvoice::STATUS_NO_NEED),
			],
		])->validate();

		$detailInvoice->update(['status' => $status]);

		$this->dispatchBrowserEvent('updated', ['message' => "Status changed to {$status} successfully."]);
    }
}
