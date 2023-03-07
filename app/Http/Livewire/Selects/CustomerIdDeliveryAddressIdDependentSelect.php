<?php

namespace App\Http\Livewire\Selects;

use Livewire\Component;
use App\Models\Customer;
use Illuminate\View\View;
use App\Models\DeliveryAddress;
use App\Models\SalesOrderEmployee;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CustomerIdDeliveryAddressIdDependentSelect extends Component
{
    use AuthorizesRequests;

    public $allCustomers;
    public $allDeliveryAddresses;

    public $selectedCustomerId;
    public $selectedDeliveryAddressId;

    protected $rules = [
        'selectedCustomerId' => ['required', 'exists:customers,id'],
        'selectedDeliveryAddressId' => [
            'nullable',
            'exists:delivery_addresses,id',
        ],
    ];

    public function mount($salesOrderEmployee): void
    {
        $this->clearData();
        $this->fillAllCustomers();

        if (is_null($salesOrderEmployee)) {
            return;
        }

        $salesOrderEmployee = SalesOrderEmployee::findOrFail(
            $salesOrderEmployee
        );

        $this->selectedCustomerId = $salesOrderEmployee->customer_id;

        $this->fillAllDeliveryAddresses();
        $this->selectedDeliveryAddressId =
            $salesOrderEmployee->delivery_address_id;
    }

    public function updatedSelectedCustomerId(): void
    {
        $this->selectedDeliveryAddressId = null;
        $this->fillAllDeliveryAddresses();
    }

    public function fillAllCustomers(): void
    {
        $this->allCustomers = Customer::all()->pluck('name', 'id');
    }

    public function fillAllDeliveryAddresses(): void
    {
        if (!$this->selectedCustomerId) {
            return;
        }

        $this->allDeliveryAddresses = DeliveryAddress::where(
            'customer_id',
            $this->selectedCustomerId
        )
            ->get()
            ->pluck('name', 'id');
    }

    public function clearData(): void
    {
        $this->allCustomers = null;
        $this->allDeliveryAddresses = null;

        $this->selectedCustomerId = null;
        $this->selectedDeliveryAddressId = null;
    }

    public function render(): View
    {
        return view(
            'livewire.selects.customer-id-delivery-address-id-dependent-select'
        );
    }
}
