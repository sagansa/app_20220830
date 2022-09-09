<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\FuelService;
use App\Models\PaymentReceipt;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PaymentReceiptFuelServicesDetail extends Component
{
    use AuthorizesRequests;

    public PaymentReceipt $paymentReceipt;
    public FuelService $fuelService;
    public $fuelServicesForSelect = [];
    public $fuel_service_id = null;

    public $showingModal = false;
    public $modalTitle = 'New FuelService';

    protected $rules = [
        'fuel_service_id' => ['required', 'exists:fuel_services,id'],
    ];

    public function mount(PaymentReceipt $paymentReceipt)
    {
        $this->paymentReceipt = $paymentReceipt;
        $this->fuelServicesForSelect = FuelService::get()->pluck('id', 'fuel_service_name');
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
        $this->modalTitle = trans(
            'crud.payment_receipt_fuel_services.new_title'
        );
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

        $this->paymentReceipt
            ->fuelServices()
            ->attach($this->fuel_service_id, []);

        $this->hideModal();
    }

    public function detach($fuelService)
    {
        $this->authorize('delete-any', FuelService::class);

        $this->paymentReceipt->fuelServices()->detach($fuelService);

        $this->resetFuelServiceData();
    }

    public function render()
    {
        return view('livewire.payment-receipt-fuel-services-detail', [
            'paymentReceiptFuelServices' => $this->paymentReceipt
                ->fuelServices()
                ->withPivot([])
                ->paginate(20),
        ]);
    }

    public function changeStatus(FuelService $fuelService, $status)
    {
        Validator::make(['status' => $status], [
			'status' => [
				'required',
				Rule::in(FuelService::STATUS_BELUM_DIBAYAR, FuelService::STATUS_SUDAH_DIBAYAR, FuelService::STATUS_SIAP_DIBAYAR, FuelService::STATUS_TIDAK_VALID),
			],
		])->validate();

		$fuelService->update(['status' => $status]);

        $this->emit($this->fuelServicesForSelect);

		$this->dispatchBrowserEvent('updated', ['message' => "Status changed to {$status} successfully."]);
    }
}
