<?php

namespace App\Http\Livewire\SalesOrderOnlines;

use App\Http\Livewire\DataTables\WithBulkAction;
use App\Http\Livewire\DataTables\WithCachedRows;
use App\Http\Livewire\DataTables\WithFilter;
use App\Http\Livewire\DataTables\WithModal;
use App\Http\Livewire\DataTables\WithPerPagePagination;
use App\Http\Livewire\DataTables\WithSortingDate;
use App\Models\DeliveryService;
use App\Models\OnlineShopProvider;
use App\Models\SalesOrderOnline;
use App\Models\Store;
use Livewire\Component;

class SalesOrderOnlinesList extends Component
{
    use WithPerPagePagination;
    // use WithSortingDate;
    // use WithModal;
    use WithBulkAction;
    // use WithCachedRows;
    use WithFilter;

    public SalesOrderOnline $editing;

    // public $sortColumn = 'sales_order_onlines.date';

    // public string $sortDirection = 'asc';

    public $filters = [
        'status' => '',
    ];

    public function rules()
    {
        return [
            // 'editing.status' => 'nullable',
            'editing.status' => 'required|in:1,2,3,4,5,6',
        ];
    }

    public function mount()
    {
        $this->stores = Store::orderBy('nickname', 'asc')->pluck('id', 'nickname');
        $this->onlineShopProviders = OnlineShopProvider::orderBy('name', 'asc')->whereIn('id', ['1', '2'])->pluck('id', 'name');
        $this->deliveryServices = DeliveryService::orderBy('name', 'asc')->pluck('id', 'name');
    }

    public function render()
    {
        $salesOrderOnlines = SalesOrderOnline::query()
            ->select(['sales_order_onlines.*', 'stores.nickname as storename'])
            ->join('stores', 'stores.id', '=', 'sales_order_onlines.store_id')
            ->with('products')
            ->orderBy('date', 'desc')
            ->latest();

        foreach ($this->filters as $filter => $value) {
            if (!empty($value)) {
                $salesOrderOnlines
                    ->when($filter == 'status', fn($salesOrderOnlines) => $salesOrderOnlines->where('sales_order_onlines.' . $filter, 'LIKE', '%' . $value . '%'));
            }
        }

        // $salesOrderOnlines->orderBy($this->sortColumn, $this->sortDirection);

        return view('livewire.sales-order-onlines.sales-order-onlines-list', [
            'salesOrderOnlines' => $salesOrderOnlines->paginate(10),
        ]);
    }

    // public function getSelectedCountProperty()
    // {
    //     return count($this->selected);
    // }

    public function sortByColumn($column)
    {
        if ($this->sortColumn == $column) {
            $this->sortDirection = $this->sortDirection == 'asc' ? 'desc' : 'asc';
        } else {
            $this->reset('sortDirection');
            $this->sortColumn = $column;
        }
    }

    public function markAllAsValid()
    {
        SalesOrderOnline::whereIn('id', $this->selectedRows)->update([
            'status' => '2',
        ]);

        $this->reset(['selectedRows']);
    }

    public function markAllAsPerbaiki()
    {
        SalesOrderOnline::whereIn('id', $this->selectedRows)->update([
            'status' => '4',
        ]);

        $this->reset(['selectedRows']);
    }

}
