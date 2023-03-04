<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\EProduct;
use Illuminate\View\View;
use App\Models\SoDdetail;
use Livewire\WithPagination;
use App\Models\SalesOrderDirect;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SalesOrderDirectSoDdetailsDetail extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public SalesOrderDirect $salesOrderDirect;
    public SoDdetail $soDdetail;
    public $eProductsForSelect = [];

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New SoDdetail';

    protected $rules = [
        'soDdetail.e_product_id' => ['required', 'exists:e_products,id'],
        'soDdetail.quantity' => ['required', 'numeric'],
        'soDdetail.price' => ['required', 'numeric'],
    ];

    public function mount(SalesOrderDirect $salesOrderDirect): void
    {
        $this->salesOrderDirect = $salesOrderDirect;
        $this->eProductsForSelect = EProduct::pluck('image', 'id');
        $this->resetSoDdetailData();
    }

    public function resetSoDdetailData(): void
    {
        $this->soDdetail = new SoDdetail();

        $this->soDdetail->e_product_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newSoDdetail(): void
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.sales_order_direct_details.new_title');
        $this->resetSoDdetailData();

        $this->showModal();
    }

    public function editSoDdetail(SoDdetail $soDdetail): void
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.sales_order_direct_details.edit_title');
        $this->soDdetail = $soDdetail;

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

        if (!$this->soDdetail->sales_order_direct_id) {
            $this->authorize('create', SoDdetail::class);

            $this->soDdetail->sales_order_direct_id =
                $this->salesOrderDirect->id;
        } else {
            $this->authorize('update', $this->soDdetail);
        }

        $this->soDdetail->save();

        $this->hideModal();
    }

    public function destroySelected(): void
    {
        $this->authorize('delete-any', SoDdetail::class);

        SoDdetail::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetSoDdetailData();
    }

    public function toggleFullSelection(): void
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->salesOrderDirect->soDdetails as $soDdetail) {
            array_push($this->selected, $soDdetail->id);
        }
    }

    public function render(): View
    {
        return view('livewire.sales-order-direct-so-ddetails-detail', [
            'soDdetails' => $this->salesOrderDirect->soDdetails()->paginate(20),
        ]);
    }
}
