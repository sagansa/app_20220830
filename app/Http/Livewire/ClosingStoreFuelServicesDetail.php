<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\FuelService;
use App\Models\ClosingStore;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Carbon;

class ClosingStoreFuelServicesDetail extends Component
{
    use AuthorizesRequests;

    public ClosingStore $closingStore;
    public FuelService $fuelService;
    public $fuelServicesForSelect = [];
    public $fuel_service_id = null;

    public $showingModal = false;
    public $modalTitle = 'New FuelService';

    protected $rules = [
        'fuel_service_id' => ['required', 'exists:fuel_services,id'],
    ];

    public function mount(ClosingStore $closingStore)
    {
        $this->closingStore = $closingStore;
        $this->fuelServicesForSelect = FuelService::where('created_at', '>=', Carbon::now()->subDays(5)->toDateString())
            ->where('payment_type_id', '=', '2')
            ->get()->pluck('fuel_service_name', 'id');
        $this->resetFuelServiceData();
    }

    public function resetFuelServiceData()
    {
        $this->fuelService = new FuelService();

        $this->fuel_service_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newFuelService()
    {
        $this->modalTitle = trans('crud.closing_store_fuel_services.new_title');
        $this->resetFuelServiceData();

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

        $this->authorize('create', FuelService::class);

        $this->closingStore->fuelServices()->attach($this->fuelService_id, []);

        $this->hideModal();
    }

    public function detach($fuelService)
    {
        $this->authorize('delete-any', FuelService::class);

        $this->closingStore->fuelServices()->detach($fuelService);

        $this->resetFuelServiceData();
    }

    public function render()
    {
        $this->fuelService->totals = 0;

        foreach ($this->closingStore->fuelServices as $fuelService) {
            $this->fuelService->totals += $fuelService['amount'];
        }

        return view('livewire.closing-store-fuel-services-detail', [
            'closingStoreFuelServices' => $this->closingStore
                ->fuelServices()
                ->withPivot([])
                ->paginate(20),
        ]);
    }
}
