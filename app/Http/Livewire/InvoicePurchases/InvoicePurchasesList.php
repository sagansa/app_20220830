<?php

namespace App\Http\Livewire\InvoicePurchases;

use App\Http\Livewire\DataTables\WithBulkAction;
use App\Http\Livewire\DataTables\WithCachedRows;
use App\Http\Livewire\DataTables\WithFilter;
use App\Http\Livewire\DataTables\WithModal;
use App\Http\Livewire\DataTables\WithPerPagePagination;
use App\Http\Livewire\DataTables\WithSortingDate;
use App\Models\InvoicePurchase;
use App\Models\PaymentType;
use App\Models\Store;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class InvoicePurchasesList extends Component
{
    use WithPerPagePagination, WithSortingDate, WithModal, WithBulkAction, WithCachedRows, WithFilter;

    public InvoicePurchase $editing;

    public $suppliers;
    public $stores;
    public $paymentTypes;

    public $sortColumn = 'invoice_purchases.created_at';

    protected $queryString = [
        'sortColumn' => [
        'except' => 'invoice_purchases.created_at'
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

    public function edit(InvoicePurchase $invoicePurchase)
    {
        $this->editing = $invoicePurchase;

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
        $this->suppliers = Supplier::orderBy('name', 'asc')->pluck('id', 'name');
        $this->stores = Store::orderBy('nickname', 'asc')->pluck('id', 'nickname');
        $this->paymentTypes = PaymentType::orderBy('name', 'asc')->whereIn('id', ['1', '2'])->pluck('id', 'name');
    }

    public function getRowsQueryProperty()
    {
        $invoicePurchases = InvoicePurchase::query()
            ->join('suppliers', 'suppliers.id', '=', 'invoice_purchases.supplier_id');

            if (Auth::user()->hasRole('staff|supervisor')) {

                $invoicePurchases->where('created_by_id', '=', Auth::user()->id);
        }

        foreach ($this->filters as $filter => $value) {
            if (!empty($value)) {
                $invoicePurchases
                    ->when($filter == 'store_id', fn($invoicePurchases) => $invoicePurchases->whereRelation('store', 'id', $value))
                    ->when($filter == 'supplier_id', fn($invoicePurchases) => $invoicePurchases->whereRelation('supplier', 'id', $value))
                    ->when($filter == 'payment_type_id', fn($invoicePurchases) => $invoicePurchases->whereRelation('paymentType', 'id', $value))
                    ->when($filter == 'payment_status', fn($invoicePurchases) => $invoicePurchases->where('invoice_purchases.' . $filter, 'LIKE', '%' . $value . '%'))
                    ->when($filter == 'order_status', fn($invoicePurchases) => $invoicePurchases->where('invoice_purchases.' . $filter, 'LIKE', '%' . $value . '%'));
            }
        }

        $invoicePurchases->withSum('detailInvoices', 'subtotal_invoice')->get();

        return $this->applySorting($invoicePurchases);
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function render()
    {
        return view('livewire.invoice-purchases.invoice-purchases-list', [
            'invoicePurchases' => $this->rows,
        ]);
    }

    public function markAllAsSudahDibayar()
    {
        InvoicePurchase::whereIn('id', $this->selectedRows)->update([
            'payment_status' => '2',
            'approved_by_id' => Auth::user()->id,
        ]);

        $this->reset(['selectedRows']);
    }

    public function markAllAsBelumDibayar()
    {
        InvoicePurchase::whereIn('id', $this->selectedRows)->update([
            'payment_status' => '1',
            'approved_by_id' => Auth::user()->id,
        ]);

        $this->reset(['selectedRows']);
    }

    public function markAllAsTidakValid()
    {
        InvoicePurchase::whereIn('id', $this->selectedRows)->update([
            'payment_status' => '3',
            'approved_by_id' => Auth::user()->id,
        ]);

        $this->reset(['selectedRows']);
    }
}
