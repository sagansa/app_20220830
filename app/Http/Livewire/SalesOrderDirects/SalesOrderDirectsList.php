<?php

namespace App\Http\Livewire\SalesOrderDirects;

use App\Http\Livewire\DataTables\WithBulkAction;
use App\Http\Livewire\DataTables\WithCachedRows;
use App\Http\Livewire\DataTables\WithFilter;
use App\Http\Livewire\DataTables\WithModal;
use App\Http\Livewire\DataTables\WithPerPagePagination;
use App\Http\Livewire\DataTables\WithSortingDate;
use App\Models\SalesOrderDirect;
use App\Models\Store;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SalesOrderDirectsList extends Component
{
    use WithPerPagePagination;
    use WithSortingDate;
    use WithCachedRows;
    use WithBulkAction;
    use WithFilter;
    use WithModal;

    public SalesOrderDirect $editing;

    public $sortColumn = 'sales_order_directs.delivery_date';

    protected $queryString = [
        'sortColumn' => [
        'except' => 'sales_order_directs.delivery_date'
        ],
        'sortDirection' => [
            'except' => 'desc',
        ],
    ];

    public $filters = [
        'storename' => '',
        'payment_status' => '',
        'delivery_status' => '',
        'store_id' => null,
        'order_by_id' => null,
    ];

    public function rules()
    {
        return [
            'editing.payment_status' => 'required|in:1,2,3',
        ];
    }

    public function edit(SalesOrderDirect $salesOrderDirect)
    {
        $this->editing = $salesOrderDirect;

        $this->showEditModal = true;
    }

    public function save()
    {
        $this->validate();

        $this->editing['submitted_by_id'] = Auth::user()->id;

        $this->editing->save();

        $this->showEditModal = false;
    }

    public function mount()
    {
        $this->stores = Store::orderBy('nickname', 'asc')->pluck('id', 'nickname');
        $this->orders = User::orderBy('name', 'asc')->pluck('id', 'name');
    }

    public function getRowsQueryProperty()
    {
        $salesOrderDirects = SalesOrderDirect::query()
            ->join('stores', 'stores.id', '=', 'sales_order_directs.store_id');

            if (Auth::user()->hasRole('customer')) {

                $salesOrderDirects->where('order_by_id', '=', Auth::user()->id);
            }

        foreach ($this->filters as $filter => $value) {
            if (!empty($value)) {
                $salesOrderDirects
                    ->when($filter == 'store_id', fn($salesOrderDirects) => $salesOrderDirects->whenRelation('store', 'id', $value))
                    ->when($filter == 'order_by_id', fn($salesOrderDirects) => $salesOrderDirects->whenRelation('user', 'id', $value))
                    ->when($filter == 'payment_status', fn($salesOrderDirects) => $salesOrderDirects->where('sales_order_directs.' . $filter, 'LIKE', '%' . $value . '%'))
                    ->when($filter == 'delivery_status', fn($salesOrderDirects) => $salesOrderDirects->where('sales_order_directs.' . $filter, 'LIKE', '%' . $value . '%'));
            }
        }

        $salesOrderDirects->withSum('salesOrderDirectProducts', 'amount')->get();

        return $this->applySorting($salesOrderDirects);
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function render()
    {
        // $salesOrderDirects = SalesOrderDirect::query()
        //     ->latest();

        // foreach ($this->filters as $filter => $value) {
        //     if (!empty($value)) {
        //         $salesOrderDirects
        //             ->when($filter == 'payment_status', fn($salesOrderDirects) => $salesOrderDirects->where('sales_order_directs.' . $filter, 'LIKE', '%' . '%'));
        //     }
        // }

        return view('livewire.sales-order-directs.sales-order-directs-list', [
            'salesOrderDirects' => $this->rows,
        ]);
    }
}
