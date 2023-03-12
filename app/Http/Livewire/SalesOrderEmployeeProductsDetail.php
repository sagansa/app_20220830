<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;
use Illuminate\View\View;
use App\Models\SalesOrderEmployee;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SalesOrderEmployeeProductsDetail extends Component
{
    use AuthorizesRequests;

    public SalesOrderEmployee $salesOrderEmployee;
    public Product $product;
    public $productsForSelect = [];
    public $product_id = null;
    public $quantity;
    public $unit_price;
    public $amount;

    public $showingModal = false;
    public $modalTitle = 'New Product';

    protected $rules = [
        'product_id' => ['required', 'exists:products,id'],
        'quantity' => ['required', 'numeric', 'gt:0'],
        'unit_price' => ['required', 'numeric', 'gt:0'],
    ];

    public function mount(SalesOrderEmployee $salesOrderEmployee): void
    {
        $this->salesOrderEmployee = $salesOrderEmployee;
        $this->productsForSelect = Product::whereNotIn('online_category_id', ['4'])->orderBy('name', 'asc')->get()->pluck('id', 'product_name');
        $this->resetProductData();
    }

    public function resetProductData(): void
    {
        $this->product = new Product();

        $this->product_id = null;
        $this->quantity = null;
        $this->unit_price = null;
        $this->amount = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newProduct(): void
    {
        $this->modalTitle = trans(
            'crud.sales_order_employee_products.new_title'
        );
        $this->resetProductData();

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

        // $this->authorize('create', SalesOrderEmployee::class);

        $this->salesOrderEmployee->products()->attach($this->product_id, [
            'quantity' => $this->quantity,
            'unit_price' => $this->unit_price,
        ]);

        $this->hideModal();
    }

    public function detach($product): void
    {
        // $this->authorize('delete-any', SalesOrdeEmployee::class);

        $this->salesOrderEmployee->products()->detach($product);

        $this->resetProductData();
    }

    public function render(): View
    {
        $this->salesOrderEmployee->totals = 0;

        foreach ($this->salesOrderEmployee->products as $product) {
            $this->salesOrderEmployee->totals += $product->pivot->quantity * $product->pivot->unit_price;
        }
        return view('livewire.sales-order-employee-products-detail', [
            'salesOrderEmployeeProducts' => $this->salesOrderEmployee
                ->products()
                ->withPivot(['quantity', 'unit_price'])
                ->paginate(20),
        ]);
    }
}
