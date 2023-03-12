<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\EProduct;
use Illuminate\View\View;
use Livewire\WithPagination;
use App\Models\SalesOrderDirect;
use App\Models\SalesOrderDirectProduct;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;

class SalesOrderDirectSalesOrderDirectProductsDetail extends Component
{

    public $state = [];

    public $subtotals;

    use WithPagination;
    use AuthorizesRequests;

    public SalesOrderDirect $salesOrderDirect;
    public SalesOrderDirectProduct $salesOrderDirectProduct;
    public $eProductsForSelect = [];

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New SalesOrderDirectProduct';

    protected $rules = [
        'salesOrderDirectProduct.e_product_id' => [
            'required',
            'exists:e_products,id',
        ],
        'salesOrderDirectProduct.quantity' => ['required', 'numeric'],
    ];

    public function mount(SalesOrderDirect $salesOrderDirect): void
    {
        $this->salesOrderDirect = $salesOrderDirect;
        $this->eProductsForSelect = EProduct::join('products', 'products.id', '=', 'e_products.product_id')
            ->orderBy('products.name', 'asc')->get()->pluck('id', 'product_name');
        $this->resetSalesOrderDirectProductData();
    }

    public function resetSalesOrderDirectProductData(): void
    {
        $this->salesOrderDirectProduct = new SalesOrderDirectProduct();

        $this->salesOrderDirectProduct->e_product_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newSalesOrderDirectProduct(): void
    {
        $this->editing = false;
        $this->modalTitle = trans(
            'crud.sales_order_direct_sales_order_direct_products.new_title'
        );
        $this->resetSalesOrderDirectProductData();

        $this->showModal();
    }

    public function editSalesOrderDirectProduct(
        SalesOrderDirectProduct $salesOrderDirectProduct
    ): void {
        $this->editing = true;
        $this->modalTitle = trans(
            'crud.sales_order_direct_sales_order_direct_products.edit_title'
        );
        $this->salesOrderDirectProduct = $salesOrderDirectProduct;

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

        if (!$this->salesOrderDirectProduct->sales_order_direct_id) {
            $this->authorize('create', SalesOrderDirectProduct::class);

            $this->salesOrderDirectProduct->sales_order_direct_id =
                $this->salesOrderDirect->id;
        } else {
            $this->authorize('update', $this->salesOrderDirectProduct);
        }

        $this->salesOrderDirectProduct->amount = $this->salesOrderDirectProduct->eProduct->price * $this->salesOrderDirectProduct->quantity;

        $this->salesOrderDirectProduct->save();

        $this->hideModal();
    }

    public function destroySelected(): void
    {
        $this->authorize('delete-any', SalesOrderDirectProduct::class);

        SalesOrderDirectProduct::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetSalesOrderDirectProductData();
    }

    public function toggleFullSelection(): void
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach (
            $this->salesOrderDirect->salesOrderDirectProducts
            as $salesOrderDirectProduct
        ) {
            array_push($this->selected, $salesOrderDirectProduct->id);
        }
    }

    public function render(): View
    {
        $this->salesOrderDirect->subtotals = 0;

        foreach ($this->salesOrderDirect->salesOrderDirectProducts as $salesOrderDirectProduct) {
            $this->salesOrderDirectProduct->subtotals += $salesOrderDirectProduct['amount'];
        }

        $this->salesOrderDirect->totals = $this->salesOrderDirectProduct->subtotals - $this->salesOrderDirect->discounts + $this->salesOrderDirect->shipping_cost;

        return view(
            'livewire.sales-order-direct-sales-order-direct-products-detail',
            [
                'salesOrderDirectProducts' => $this->salesOrderDirect
                    ->salesOrderDirectProducts()
                    ->paginate(20),
            ],
        );
    }

    public function updateOrder()
    {
        Validator::make(
            $this->state,
            [
                'discounts' => 'required', 'numeric', 'min:0',
                'shipping_cost' => 'required', 'numeric', 'min:0',
            ])->validate();

        $this->salesOrderDirect->update($this->state);
    }
}
