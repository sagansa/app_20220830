<?php

namespace App\Http\Livewire\RequestPurchases;

use App\Http\Livewire\DataTables\WithBulkAction;
use App\Http\Livewire\DataTables\WithCachedRows;
use App\Http\Livewire\DataTables\WithFilter;
use App\Http\Livewire\DataTables\WithModal;
use App\Http\Livewire\DataTables\WithPerPagePagination;
use App\Http\Livewire\DataTables\WithSortingDate;
use App\Models\RequestPurchase;
use App\Models\Store;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class RequestPurchasesList extends Component
{
    use WithPerPagePagination, WithSortingDate, WithModal, WithBulkAction, WithCachedRows, WithFilter;

    public RequestPurchase $editing;

    public $sortColumn = 'request_purchases.date';

    protected $queryString = [
        'sortColumn' => [
        'except' => 'request_purchases.date'
        ],
        'sortDirection' => [
            'except' => 'desc',
        ],
    ];

    public $filters = [
        'storename' => '',
        'payment_status' => '',
        'order_status' => '',
        'store_id' => null,
        'supplier_id' => null,
        'payment_type_id' => null,
    ];

    public function rules()
    {
        return [
            'editing.notes' => 'nullable',
            'editing.payment_status' => 'required|in:1,2,3',
        ];
    }

    public function edit(RequestPurchase $requestPurchase)
    {
        $this->editing = $requestPurchase;

        $this->showEditModal = true;
    }

    public function save()
    {
        $this->validate();

        $this->editing['approved_by_id'] = Auth::user()->id;

        $this->editing->save();

        $this->showEditModal = false;
    }

    public function mount()
    {
        $this->stores = Store::orderBy('nickname', 'asc')->pluck('id', 'nickname');
    }

    public function getRowsQueryProperty()
    {
        $requestPurchases = RequestPurchase::query();

        foreach ($this->filters as $filter => $value) {
            if (!empty($value)) {
                $requestPurchases
                    ->when($filter == 'store_id', fn($requestPurchases) => $requestPurchases->whereRelation('store', 'id', $value))
                    ->when($filter == 'status', fn($requestPurchases) => $requestPurchases->where('request_purchases.' . $filter, 'LIKE', '%' . $value . '%'));
            }
        }

        if (Auth::user()->hasRole('staff|supervisor')) {

                $requestPurchases->where('created_by_id', '=', Auth::user()->id);
        }

        return $this->applySorting($requestPurchases);
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function render()
    {
        return view('livewire.request-purchases.request-purchases-list', [
            'requestPurchases' => $this->rows,
        ]);
    }

    public function markAllAsProcess()
    {
        RequestPurchase::whereIn('id', $this->selectedRows)->update([
            'status' => '1',
            'approved_by_id' => Auth::user()->id,
        ]);

        $this->reset(['selectedRows']);
    }

    public function markAllAsDone()
    {
        RequestPurchase::whereIn('id', $this->selectedRows)->update([
            'status' => '2',
            'approved_by_id' => Auth::user()->id,
        ]);

        $this->reset(['selectedRows']);
    }
}
