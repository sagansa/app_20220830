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
use Livewire\WithPagination;

class SalesOrderOnlinesList extends Component
{
    use WithPerPagePagination;
    // use WithSortingDate;
    // use WithModal;
    use WithBulkAction;
    // use WithCachedRows;
    use WithFilter;

    public SalesOrderOnline $editing;

    public array $selected = [];

    // public $sortColumn = 'sales_order_onlines.date';

    // public string $sortDirection = 'asc';

    public $filters = [
        'store_id' => null,
        'supplier_id' => null,
        'payment_type_id' => null,
        'status' => '',
    ];

    public function mount()
    {
        $this->stores = Store::orderBy('nickname', 'asc')->pluck('id', 'nickname');
        $this->onlineShopProviders = OnlineShopProvider::orderBy('name', 'asc')->whereIn('id', ['1', '2'])->pluck('id', 'name');
        $this->deliveryServices = DeliveryService::orderBy('name', 'asc')->pluck('id', 'name');
    }

    public function render()
    {
<<<<<<< HEAD
        $salesOrderOnlines = SalesOrderOnline::query();
=======
        $salesOrderOnlines = SalesOrderOnline::query()
            ->orderBy('date', 'desc')
            ->latest();
>>>>>>> f7bc24b16a7fcd38167a193a0cef5b28d0c2ea1a

        foreach ($this->filters as $filter => $value) {
            if (!empty($value)) {
                $salesOrderOnlines
                    ->when($filter == 'status', fn($salesOrderOnlines) => $salesOrderOnlines->where('sales_order_onlines.' . $filter, 'LIKE', '%' . $value . '%'));
            }
        }

        foreach ($salesOrderOnlines as $salesOrderOnline) {
            $salesOrderOnline->total = 0;
            foreach ($salesOrderOnline->products as $product) {
                $salesOrderOnline->total += $product->pivot->quantity * $product->pivot->price;
            }
        }

        return view('livewire.sales-order-onlines.sales-order-onlines-list', [
            'salesOrderOnlines' => $salesOrderOnlines->paginate(10),
        ]);
    }

    public function getSelectedCountProperty()
    {
        return count($this->selected);
    }

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
