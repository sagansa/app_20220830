<?php

namespace App\Http\Livewire\DetailInvoices;

use App\Http\Livewire\DataTables\WithBulkAction;
use App\Http\Livewire\DataTables\WithCachedRows;
use App\Http\Livewire\DataTables\WithFilter;
use App\Http\Livewire\DataTables\WithModal;
use App\Http\Livewire\DataTables\WithSimpleTablePagination;
use App\Http\Livewire\DataTables\WithSorting;
use App\Models\DetailRequest;
use App\Models\Product;
use App\Models\Store;
use App\Models\Supplier;
use Livewire\Component;

class UnitPricePurchases extends Component
{
    use WithSimpleTablePagination, WithSorting, WithModal, WithBulkAction, WithCachedRows, WithFilter;

    public DetailRequest $editing;

    public $sortColumn = 'detail_requests.created_at';

    protected $queryString = [
        'sortColumn' => [
        'except' => 'detail_requests.created_at'
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

    public function render()
    {
        return view('livewire.detail-invoices.unit-price-purchases', [
            'detailRequests' => $this->rows,
        ]);
    }

    public function mount()
    {
        $this->suppliers = Supplier::orderBy('name', 'asc')->pluck('id', 'name');
        $this->stores = Store::orderBy('nickname', 'asc')->pluck('id', 'nickname');
        $this->products = Product::orderBy('name', 'asc')->pluck('id', 'name');
    }

    public function getRowsQueryProperty()
    {
        // $detailInvoices = DetailInvoice::query()
        //     ->join('invoice_purchases', 'invoice_purchases.id', '=', 'detail_invoices.invoice_purchase_id')
        //     ->join('detail_requests', 'detail_requests.id', '=', 'detail_invoices.detail_request_id')
        //     ->join('suppliers', 'suppliers.id', '=', 'invoice_purchase_id')
        //     ->select('detail_invoices.*', 'invoice_purchases.store_id', 'invoice_purchases.supplier_id', 'detail_requests.product_id')
        //     ->get();

        $detailRequests = DetailRequest::query();

            foreach ($this->filters as $filter => $value) {
                if (!empty($value)) {
                    $detailRequests
                        ->when($filter == 'store_id', fn($detailRequests) => $detailRequests->whereRelation('store', 'id', $value))
                        ->when($filter == 'supplier_id', fn($detailRequests) => $detailRequests->whereRelation('supplier', 'id', $value))
                        ->when($filter == 'product_id', fn($detailRequests) => $detailRequests->whereRelation('product', 'id', $value));
                }
            }

        return $this->applySorting($detailRequests);
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    // public DetailInvoice $editing;

    // public $sortColumn = 'detail_invoices.created_at';

    // protected $queryString = [
    //     'sortColumn' => [
    //     'except' => 'detail_invoices.date'
    //     ],
    //     'sortDirection' => [
    //         'except' => 'asc',
    //     ],
    // ];

    // public $filters = [
    //     'status' => '',
    //     'invoice_purchases.store_id' => null,
    //     'invoice_purchases.supplier_id' => null,
    //     'product_id' => null,
    // ];

    // public function mount()
    // {
    //     $this->suppliers = Supplier::orderBy('name', 'asc')->pluck('id', 'name');
    //     $this->stores = Store::orderBy('nickname', 'asc')->pluck('id', 'nickname');
    //     $this->products = Product::orderBy('name', 'asc')->pluck('id', 'name');
    // }

    // public function getRowsQueryProperty()
    // {
    //     // $detailInvoices = DetailInvoice::query()
    //     //     ->join('invoice_purchases', 'invoice_purchases.id', '=', 'detail_invoices.invoice_purchase_id')
    //     //     ->join('detail_requests', 'detail_requests.id', '=', 'detail_invoices.detail_request_id')
    //     //     ->join('suppliers', 'suppliers.id', '=', 'invoice_purchase_id')
    //     //     ->select('detail_invoices.*', 'invoice_purchases.store_id', 'invoice_purchases.supplier_id', 'detail_requests.product_id')
    //     //     ->get();

    //     $detailInvoices = DetailInvoice::query();

    //         foreach ($this->filters as $filter => $value) {
    //             if (!empty($value)) {
    //                 $detailInvoices
    //                     ->when($filter == 'invoice_purchases.store_id', fn($detailInvoices) => $detailInvoices->whereRelation('store', 'id', $value))
    //                     ->when($filter == 'invoice_purchases.supplier_id', fn($detailInvoices) => $detailInvoices->whereRelation('supplier', 'id', $value))
    //                     // ->when($filter == 'detail_requests.product_id', fn($detailInvoices) => $detailInvoices->whereRelation('product', 'id', $value))
    //                     ->when($filter == 'detail_requests.product_id', fn($detailInvoices) => $detailInvoices->whereRelation('detail_requests', 'product_id', '=', $value));
    //             }
    //         }

    //     // $detailInvoices = DetailInvoice::whereRelation('detail_requests', 'product_id', '=', $value);

    //     return $this->applySorting($detailInvoices);
    // }



    // public function render()
    // {
    //     // $detailInvoices = DetailInvoice::query()
    //     //     ->join('invoice_purchases', 'invoice_purchases.id', '=', 'detail_invoices.invoice_purchase_id')
    //     //     ->join('detail_requests', 'detail_requests.id', '=', 'detail_invoices.detail_request_id')
    //     //     ->join('suppliers', 'suppliers.id', '=', 'invoice_purchase_id')
    //     //     ->select('detail_invoices.*', 'invoice_purchases.store_id', 'invoice_purchases.supplier_id', 'detail_requests.product_id')
    //     //     ->get();

    //     $detailInvoices = DetailInvoice::query();

    //         foreach ($this->filters as $filter => $value) {
    //             if (!empty($value)) {
    //                 $detailInvoices
    //                     ->when($filter == 'invoice_purchases.store_id', fn($detailInvoices) => $detailInvoices->whereRelation('store', 'id', $value))
    //                     ->when($filter == 'invoice_purchases.supplier_id', fn($detailInvoices) => $detailInvoices->whereRelation('supplier', 'id', $value))
    //                     // ->when($filter == 'detail_requests.product_id', fn($detailInvoices) => $detailInvoices->whereRelation('product', 'id', $value))
    //                     ->when($filter == 'detail_requests.product_id', fn($detailInvoices) => $detailInvoices->whereRelation('detail_requests', 'product_id', '=', $value));
    //             }
    //         }

    //     return view('livewire.detail-invoices.unit-price-purchases', [
    //         'detailInvoices' => $this->rows,
    //     ]);
    // }
}
