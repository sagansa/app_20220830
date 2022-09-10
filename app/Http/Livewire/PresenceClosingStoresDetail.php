<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Presence;
use App\Models\ClosingStore;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Carbon;

class PresenceClosingStoresDetail extends Component
{
    use AuthorizesRequests;

    public Presence $presence;
    public ClosingStore $closingStore;
    public $closingStoresForSelect = [];
    public $closing_store_id = null;

    public $showingModal = false;
    public $modalTitle = 'New ClosingStore';

    protected $rules = [
        'closing_store_id' => ['required', 'exists:closing_stores,id'],
    ];

    public function mount(Presence $presence)
    {
        $this->presence = $presence;
        $this->closingStoresForSelect = ClosingStore::where('date', '>=', Carbon::now()->subDays(3)->toDateString())
            ->orderBy('date', 'desc')
            ->get()
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
        $this->modalTitle = trans('crud.presence_closing_stores.new_title');
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

        $this->presence->closingStores()->attach($this->closing_store_id, []);

        $this->hideModal();
    }

    public function detach($closingStore)
    {
        $this->authorize('delete-any', ClosingStore::class);

        $this->presence->closingStores()->detach($closingStore);

        $this->resetClosingStoreData();
    }

    public function render()
    {
        return view('livewire.presence-closing-stores-detail', [
            'presenceClosingStores' => $this->presence
                ->closingStores()
                ->withPivot([])
                ->paginate(20),
        ]);
    }
}
