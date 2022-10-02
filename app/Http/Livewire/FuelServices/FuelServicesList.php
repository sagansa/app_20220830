<?php

namespace App\Http\Livewire\FuelServices;

use App\Http\Livewire\DataTables\WithBulkAction;
use App\Http\Livewire\DataTables\WithCachedRows;
use App\Http\Livewire\DataTables\WithFilter;
use App\Http\Livewire\DataTables\WithModal;
use App\Http\Livewire\DataTables\WithPerPagePagination;
use App\Http\Livewire\DataTables\WithSorting;
use App\Models\FuelService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FuelServicesList extends Component
{
    use WithPerPagePagination, WithSorting, WithModal, WithBulkAction, WithCachedRows, WithFilter;

    public FuelService $fuelService;

    public $fuelServiceDate;

    public $sortColumn = 'fuel_services.created_at';

    protected $queryString = [
        'sortColumn' => [
        'except' => 'fuel_services.created_at'
        ],
        'sortDirection' => [
            'except' => 'desc',
        ],
    ];

    public $filters = [
        'status' => '',
    ];

    public function getRowsQueryProperty()
    {

        $fuelServices = FuelService::query()
            ->orderBy('date', 'desc');

        foreach ($this->filters as $filter => $value) {
            if (!empty($value)) {
                $fuelServices
                    ->when($filter == 'payment_type_id', fn($fuelServices) => $fuelServices->whereRelation('paymentType', 'id', $value))
                    ->when($filter == 'created_by_id', fn($fuelServices) => $fuelServices->whereRelation('created_by', 'id', $value))
                    ->when($filter == 'status', fn($fuelServices) => $fuelServices->where('daily_salaries.' . $filter, 'LIKE', '%' . $value . '%'));
            }
        }

        if (Auth::user()->hasRole('staff|supervisor|manager')) {

            $fuelServices->where('created_by_id', '=', Auth::user()->id);

        }

        return $this->applySorting($fuelServices);
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function render()
    {
        return view('livewire.fuel-services.fuel-services-list', [
            'fuelServices' => $this->rows,
        ]);
    }
}
