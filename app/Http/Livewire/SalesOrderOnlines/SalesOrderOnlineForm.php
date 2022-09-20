<?php

namespace App\Http\Livewire\SalesOrderOnlines;

use App\Models\Customer;
use App\Models\DeliveryAddress;
use App\Models\DeliveryService;
use App\Models\OnlineShopProvider;
use App\Models\Product;
use App\Models\SalesOrderOnline;
use App\Models\Store;
use App\Models\User;
// use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithFileUploads;

class SalesOrderOnlineForm extends Component
{
    use WithFileUploads;

    public SalesOrderOnline $salesOrderOnline;

    public Collection $allProducts;

    public array $salesOrderOnlineProducts = [];

    public bool $editing = false;

    public array $listsForFields = [];

    public $uploadIteration = 0;

    public $salesOrderOnlineDate;
    public $salesOrderOnlineImage;
    public $salesOrderOnlineImageSent;

    public $selected = [];

    public function mount(SalesOrderOnline $salesOrderOnline)
    {
        $this->salesOrderOnline = $salesOrderOnline;

        if ($this->salesOrderOnline->exists()) {
            $this->editing = true;

            foreach ($this->salesOrderOnline->products()->get() as $product) {
                $this->salesOrderOnlineProducts[] = [
                    'product_id' => $product->id,
                    'quantity' => $product->pivot->quantity,
                    'price' => $product->pivot->price,
                    'product_name' => $product->name,
                    'is_saved' => true,
                ];
            }
        } else {
            $this->editing = false;

            $this->salesOrderOnline->date = today();
        }

        $this->initListsForFields();
    }

    public function render()
    {
        $this->salesOrderOnline->totals = 0;

        foreach ($this->salesOrderOnlineProducts as $salesOrderOnlineProduct) {
            if ($salesOrderOnlineProduct['is_saved'] && $salesOrderOnlineProduct['price'] && $salesOrderOnlineProduct['quantity']) {
                $this->salesOrderOnline->totals += $salesOrderOnlineProduct['price'] * $salesOrderOnlineProduct['quantity'];
            }
        }

        return view('livewire.sales-order-onlines.sales-order-online-form');
    }

    public function addProduct()
    {
        foreach ($this->salesOrderOnlineProducts as $key => $product) {
            if (!$product['is_saved']) {
                $this->addError('salesOrderOnlineProducts.' . $key, 'This line must be saved before creating a new one.');
                return;
            }
        }

        $this->salesOrderOnlineProducts[] = [
            'product_id' => '',
            'quantity' => 1,
            'price' => '',
            'is_saved' => false,
            'product_name' => '',
        ];
    }

    public function saveProduct($index)
    {
        $this->resetErrorBag();
        $product = $this->allProducts->find($this->salesOrderOnlineProducts[$index]['product_id']);
        $this->salesOrderOnlineProducts[$index]['product_name'] = $product->name;
        $this->salesOrderOnlineProducts[$index]['is_saved'] = true;
    }

    public function editProduct($index)
    {
        foreach ($this->salesOrderOnlineProducts as $key => $invoiceProduct) {
            if (!$invoiceProduct['is_saved']) {
                $this->addError('$this->salesOrderOnlineProducts.' . $key, 'This line must be saved before editing another.');
                return;
            }
        }

        $this->salesOrderOnlineProducts[$index]['is_saved'] = false;
    }

    public function removeProduct($index)
    {
        unset($this->salesOrderOnlineProducts[$index]);
        $this->salesOrderOnlineProducts = array_values($this->salesOrderOnlineProducts);
    }

    public function save()
    {
        $this->validate();

        $this->salesOrderOnline->totals = $this->salesOrderOnline->totals;

        if ($this->salesOrderOnlineImage) {
            $this->salesOrderOnline->image = $this->salesOrderOnlineImage->store(
                'public'
            );
        }

        if ($this->salesOrderOnlineImageSent) {
            $this->salesOrderOnline->image_sent = $this->salesOrderOnlineImageSent->store(
                'public'
            );
        }

        $this->salesOrderOnline->date = \Carbon\Carbon::parse(
            $this->salesOrderOnlineDate
        );

        $this->uploadIteration++;

        $this->salesOrderOnline->save();

        $products = [];

        foreach ($this->salesOrderOnlineProducts as $product) {
            $products[$product['product_id']] = [
                'price' => $product['price'],
                'quantity' => $product['quantity'],
            ];
        }

        $this->salesOrderOnline->products()->sync($products);

        return redirect()->route('sales-order-onlines.index');
    }

    public function rules(): array
    {
        return [
            'salesOrderOnline.store_id' => ['required', 'exists:stores,id'],
            'salesOrderOnline.customer_id' => ['nullable', 'exists:customers,id'],
            'salesOrderOnline.delivery_address_id' => [
                'nullable',
                'exists:delivery_addresses,id',
            ],
            'salesOrderOnlineImage' => ['nullable', 'image'],
            'salesOrderOnline.online_shop_provider_id' => [
                'required',
                'exists:online_shop_providers,id',
            ],
            'salesOrderOnline.delivery_service_id' => [
                'required',
                'exists:delivery_services,id',
            ],
            'salesOrderOnlineDate' => ['required', 'date'],
            'salesOrderOnline.receipt_no' => ['nullable', 'max:255', 'string'],
            'salesOrderOnline.notes' => ['nullable', 'max:255', 'string'],
            'salesOrderOnlineImageSent' => ['image', 'nullable'],
            'salesOrderOnline.status' => ['required', 'max:255'],
            // 'SalesOrderOnline.totals' => ['required', 'numeric'],
        ];
    }

    protected function initListsForFields(): void
    {
        $this->listsForFields['users'] = User::pluck('name', 'id')->toArray();

        $this->allProducts = Product::all();

        $this->storesForSelect = Store::pluck('name', 'id');
        $this->customersForSelect = Customer::pluck('name', 'id');
        $this->deliveryAddressesForSelect = DeliveryAddress::pluck(
            'name',
            'id'
        );
        $this->onlineShopProvidersForSelect = OnlineShopProvider::pluck(
            'name',
            'id'
        );
        $this->deliveryServicesForSelect = DeliveryService::pluck('name', 'id');
    }
}
