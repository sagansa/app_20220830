<?php

namespace App\Http\Livewire\Selects;

use Livewire\Component;
use App\Models\Regency;
use App\Models\Province;
use App\Models\District;
use Illuminate\View\View;
use App\Models\DeliveryLocation;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProvinceIdRegencyIdDistrictIdDependentSelect extends Component
{
    use AuthorizesRequests;

    public $allProvinces;
    public $allRegencies;
    public $allDistricts;

    public $selectedProvinceId;
    public $selectedRegencyId;
    public $selectedDistrictId;

    protected $rules = [
        'selectedProvinceId' => ['nullable', 'exists:provinces,id'],
        'selectedRegencyId' => ['nullable', 'exists:regencies,id'],
        'selectedDistrictId' => ['nullable', 'exists:districts,id'],
    ];

    public function mount($deliveryLocation): void
    {
        $this->clearData();
        $this->fillAllProvinces();

        if (is_null($deliveryLocation)) {
            return;
        }

        $deliveryLocation = DeliveryLocation::findOrFail($deliveryLocation);

        $this->selectedProvinceId = $deliveryLocation->province_id;

        $this->fillAllRegencies();
        $this->selectedRegencyId = $deliveryLocation->regency_id;

        $this->fillAllDistricts();
        $this->selectedDistrictId = $deliveryLocation->district_id;
    }

    public function updatedSelectedProvinceId(): void
    {
        $this->selectedRegencyId = null;
        $this->fillAllRegencies();
    }

    public function updatedSelectedRegencyId(): void
    {
        $this->selectedDistrictId = null;
        $this->fillAllDistricts();
    }

    public function fillAllProvinces(): void
    {
        $this->allProvinces = Province::all()->pluck('name', 'id');
    }

    public function fillAllRegencies(): void
    {
        if (!$this->selectedProvinceId) {
            return;
        }

        $this->allRegencies = Regency::where(
            'province_id',
            $this->selectedProvinceId
        )
            ->get()
            ->pluck('name', 'id');
    }

    public function fillAllDistricts(): void
    {
        if (!$this->selectedRegencyId) {
            return;
        }

        $this->allDistricts = District::where(
            'regency_id',
            $this->selectedRegencyId
        )
            ->get()
            ->pluck('name', 'id');
    }

    public function clearData(): void
    {
        $this->allProvinces = null;
        $this->allRegencies = null;
        $this->allDistricts = null;

        $this->selectedProvinceId = null;
        $this->selectedRegencyId = null;
        $this->selectedDistrictId = null;
    }

    public function render(): View
    {
        return view(
            'livewire.selects.province-id-regency-id-district-id-dependent-select'
        );
    }
}
