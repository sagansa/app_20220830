<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ClosingStore;
use App\Models\InvoicePurchase;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

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
        $this->closingStoresForSelect = ClosingStore::whereNotIn('status', ['2'])
            ->where('store_id', $this->invoicePurchase->store_id)
            ->orderBy('date', 'desc')
            ->get()
            ->pluck('id', 'closing_store_name');

        if (Auth::user()->hasRole('manager|super-admin')) {
            $this->closingStoresForSelect->where('date', '>=', Carbon::now()->subDays(30)->toDateString());
        }

        if (Auth::user()->hasRole('supervisor|staff')) {
            $this->closingStoresForSelect->where('date', '>=', Carbon::now()->subDays(5)->toDateString());
        }

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
            ->attach($this->closing_store_id, []);

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
