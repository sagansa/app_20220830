<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ClosingStore;
use App\Models\InvoicePurchase;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class InvoicePurchaseClosingStoresDetail extends Component
{
    use AuthorizesRequests;

    public InvoicePurchase $invoicePurchase;
    public ClosingStore $closingStore;
    public $closingStoresForSelect = [];
    public $closing_store_id = null;

    public $showingModal = false;
    public $modalTitle = 'New ClosingStore';

    protected $rules = [
        'closing_store_id' => ['required', 'exists:closing_stores,id'],
    ];

    public function mount(InvoicePurchase $invoicePurchase)
    {
        $this->invoicePurchase = $invoicePurchase;
        $this->closingStoresForSelect = ClosingStore::
            get()
            ->pluck('id', 'closing_store_name');
        $this->resetClosingStoreData();
    }

    public function resetClosingStoreData()
    {
        $this->closingStore = new ClosingStore();

        $this->closing_store_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newClosingStore()
    {
        $this->modalTitle = trans(
            'crud.invoice_purchase_closing_stores.new_title'
        );
        $this->resetClosingStoreData();

        $this->showModal();
    }

    public function showModal()
    {
        $this->resetErrorBag();
        $this->showingModal = true;
    }

    public function hideModal()
    {
        $this->showingModal = false;
    }

    public function save()
    {
        $this->validate();

        $this->authorize('create', ClosingStore::class);

        $this->invoicePurchase
            ->closingStores()
            ->attach($this->closingStore_id, []);

        $this->hideModal();
    }

    public function detach($closingStore)
    {
        $this->authorize('delete-any', ClosingStore::class);

        $this->invoicePurchase->closingStores()->detach($closingStore);

        $this->resetClosingStoreData();
    }

    public function render()
    {
        return view('livewire.invoice-purchase-closing-stores-detail', [
            'invoicePurchaseClosingStores' => $this->invoicePurchase
                ->closingStores()
                ->withPivot([])
                ->paginate(20),
        ]);
    }
}
