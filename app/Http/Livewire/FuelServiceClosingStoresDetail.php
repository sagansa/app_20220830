<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\FuelService;
use App\Models\ClosingStore;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Carbon;

class FuelServiceClosingStoresDetail extends Component
{
    use AuthorizesRequests;

    public FuelService $fuelService;
    public ClosingStore $closingStore;
    public $closingStoresForSelect = [];
    public $closing_store_id = null;

    public $showingModal = false;
    public $modalTitle = 'New ClosingStore';

    protected $rules = [
        'closing_store_id' => ['required', 'exists:closing_stores,id'],
    ];

    public function mount(FuelService $fuelService)
    {
        $this->fuelService = $fuelService;
        $this->closingStoresForSelect = ClosingStore::
            join('stores', 'stores.id', '=', 'closing_stores.store_id')
            ->join('shift_stores', 'shift_stores.id', '=', 'closing_stores.shift_store_id')
            ->select('stores.nickname', 'shift_stores.name', 'closing_stores.date')
            ->orderBy('closing_stores.date', 'desc')
            ->where('date', '>=', Carbon::now()->subDays(5)->toDateString())
            ->orderBy('date', 'desc')
            ->get()
            ->pluck('closing_store_name', 'id');
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
        $this->modalTitle = trans('crud.fuel_service_closing_stores.new_title');
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

        $this->fuelService->closingStores()->attach($this->closing_store_id, []);

        $this->hideModal();
    }

    public function detach($closingStore)
    {
        $this->authorize('delete-any', ClosingStore::class);

        $this->fuelService->closingStores()->detach($closingStore);

        $this->resetClosingStoreData();
    }

    public function render()
    {
        return view('livewire.fuel-service-closing-stores-detail', [
            'fuelServiceClosingStores' => $this->fuelService
                ->closingStores()
                ->withPivot([])
                ->paginate(20),
        ]);
    }
}
