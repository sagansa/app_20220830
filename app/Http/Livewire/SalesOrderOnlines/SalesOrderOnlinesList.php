<?php

namespace App\Http\Livewire\SalesOrderOnlines;

use App\Http\Livewire\DataTables\WithBulkAction;
use App\Http\Livewire\DataTables\WithCachedRows;
use App\Http\Livewire\DataTables\WithFilter;
use App\Http\Livewire\DataTables\WithModal;
use App\Http\Livewire\DataTables\WithPerPagePagination;
use App\Http\Livewire\DataTables\WithSortingDate;
use App\Models\Customer;
use App\Models\DeliveryService;
use App\Models\OnlineShopProvider;
use App\Models\SalesOrderOnline;
use App\Models\Store;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class SalesOrderOnlinesList extends Component
{

    use WithPerPagePagination, WithSortingDate, WithModal, WithBulkAction, WithCachedRows, WithFilter;

    // public SalesOrderOnline $salesOrderOnline;
    use WithPagination;
    public SalesOrderOnline $editing;

    public $salesOrderOnline;

    public $productSalesOrderOnlines = [];

    public $sortColumn = 'sales_order_onlines.date';

    protected $queryString = [
        'sortColumn' => [
        'except' => 'sales_order_onlines.date'
        ],
        'sortDirection' => [
            'except' => 'desc',
        ],
    ];

    public $filters = [
        'payment_status' => '',
        'order_status' => '',
        'store_id' => null,
        'supplier_id' => null,
        'payment_type_id' => null,
    ];

    public function mount(SalesOrderOnline $salesOrderOnline)
    {
        $this->customers = Customer::orderBy('name', 'asc')->pluck('id', 'name');
        $this->stores = Store::orderBy('nickname', 'asc')->pluck('id', 'nickname');
        $this->onlineShopProviders = OnlineShopProvider::orderBy('name', 'asc')->whereIn('id', ['1', '2'])->pluck('id', 'name');
        $this->deliveryServices = DeliveryService::orderBy('name', 'asc')->pluck('id', 'name');

        $this->salesOrderOnline = $salesOrderOnline;

        if ($this->salesOrderOnline) {
            foreach ($this->salesOrderOnline->products as $product) {
                $this->productSalesOrderOnlines[] = [
                    'product_id' => $product->id,
                    'quantity' => $product->pivot->quantity,
                    'price' => $product->pivot->price,
                ];
            }
        }
    }

    public function getRowsQueryProperty()
    {
        $salesOrderOnlines = SalesOrderOnline::orderBy('date', 'desc')->latest();

        foreach ($this->filters as $filter => $value) {
                if (!empty($value)) {
                    $salesOrderOnlines
                        ->when($filter == 'store_id', fn($salesOrderOnlines) => $salesOrderOnlines->whereRelation('store', 'id', $value))
                        // ->when($filter == 'customer_id', fn($salesOrderOnlines) => $salesOrderOnlines->whereRelation('customer', 'id', $value))
                        ->when($filter == 'online_shop_provider_id', fn($salesOrderOnlines) => $salesOrderOnlines->whereRelation('onlineShopProvider', 'id', $value))
                        ->when($filter == 'delivery_service_id', fn($salesOrderOnlines) => $salesOrderOnlines->whereRelation('deliveryService', 'id', $value))
                        ->when($filter == 'status', fn($salesOrderOnlines) => $salesOrderOnlines->where('sales_order_onlines.' . $filter, 'LIKE', '%' . $value . '%'));
                }
            }



        return $this->applySorting($salesOrderOnlines);
    }

     public function render()
    {
        $total = 0;

        foreach ($this->productSalesOrderOnlines as $productSalesOrderOnline) {
            if ($productSalesOrderOnline['quantity'] && $productSalesOrderOnline['price']) {
                $total += $productSalesOrderOnline['quantity'] * $productSalesOrderOnline['price'];
            }
        }

        return view('livewire.sales-order-onlines.sales-order-onlines-list', [
            'salesOrderOnlines' => $this->rows,
            'total' => $total,
        ]);
    }

    public function markAllAsBelumDikirim()
    {
        SalesOrderOnline::whereIn('id', $this->selectedRows)->update([
            'status' => '1',
            'approved_by_id' => Auth::user()->id,
        ]);

        $this->dispatchBrowserEvent('updated', ['message' => 'Sales Order Online marked as belum dikirim']);

        $this->reset(['selectedRows']);
    }

    public function markAllAsValid()
    {
        SalesOrderOnline::whereIn('id', $this->selectedRows)->update([
            'status' => '2',
            'approved_by_id' => Auth::user()->id,
        ]);

        $this->reset(['selectedRows']);
    }

    public function markAllAsSudahDikirim()
    {
        SalesOrderOnline::whereIn('id', $this->selectedRows)->update([
            'status' => '3',
            'approved_by_id' => Auth::user()->id,
        ]);

        $this->reset(['selectedRows']);
    }

    public function markAllAsDikembalikan()
    {
        SalesOrderOnline::whereIn('id', $this->selectedRows)->update([
            'status' => '6',
            'approved_by_id' => Auth::user()->id,
        ]);

        $this->reset(['selectedRows']);
    }

    public function markAllAsPerbaiki()
    {
        SalesOrderOnline::whereIn('id', $this->selectedRows)->update([
            'status' => '4',
            'approved_by_id' => Auth::user()->id,
        ]);

        $this->reset(['selectedRows']);
    }

    public function markAllAsSiapDikirim()
    {
        SalesOrderOnline::whereIn('id', $this->selectedRows)->update([
            'status' => '6',
            'approved_by_id' => Auth::user()->id,
        ]);

        $this->reset(['selectedRows']);
    }
}
