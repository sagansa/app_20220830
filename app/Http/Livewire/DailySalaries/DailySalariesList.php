<?php

namespace App\Http\Livewire\DailySalaries;

use App\Http\Livewire\DataTables\WithBulkAction;
use App\Http\Livewire\DataTables\WithCachedRows;
use App\Http\Livewire\DataTables\WithFilter;
use App\Http\Livewire\DataTables\WithModal;
use App\Http\Livewire\DataTables\WithPerPagePagination;
use App\Http\Livewire\DataTables\WithSortingDate;
use App\Models\DailySalary;
use App\Models\PaymentType;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DailySalariesList extends Component
{
    use WithPerPagePagination, WithSortingDate, WithModal, WithBulkAction, WithCachedRows, WithFilter;

    public DailySalary $editing;

    public $sortColumn = 'daily_salaries.date';

    protected $queryString = [
        'sortColumn' => [
        'except' => 'daily_salaries.date'
        ],
        'sortDirection' => [
            'except' => 'desc',
        ],
    ];

    public $filters = [
        'created_by_id' => null,
        'status' => '',
        'payment_type_id' => null,
    ];

    public function rules()
    {
        return [
            'editing.date' => 'required',
            'editing.notes' => 'nullable',
            'editing.status' => 'required|in:1,2,3,4',
        ];
    }

    public function edit(DailySalary $dailySalary)
    {
        $this->editing = $dailySalary;

        $this->showEditModal = true;
    }

    public function save()
    {
        $this->validate();

        $this->editing['approved_by_id'] = Auth::user()->id;

        $this->editing->save();

        $this->showEditModal = false;
    }

    public function mount()
    {
        $this->paymentTypes = PaymentType::orderBy('name', 'asc')->whereIn('id', ['1', '2'])->pluck('id', 'name');
        $this->users = User::orderBy('name', 'asc')->pluck('id', 'name');
    }

    public function getRowsQueryProperty()
    {

        $dailySalaries = DailySalary::query()
            ->orderBy('date', 'desc');

        foreach ($this->filters as $filter => $value) {
            if (!empty($value)) {
                $dailySalaries
                    ->when($filter == 'payment_type_id', fn($dailySalaries) => $dailySalaries->whereRelation('paymentType', 'id', $value))
                    ->when($filter == 'created_by_id', fn($dailySalaries) => $dailySalaries->whereRelation('created_by', 'id', $value))
                    ->when($filter == 'status', fn($dailySalaries) => $dailySalaries->where('daily_salaries.' . $filter, 'LIKE', '%' . $value . '%'));
            }
        }

        if (Auth::user()->hasRole('staff|supervisor|manager')) {

            $dailySalaries->where('created_by_id', '=', Auth::user()->id);

        }

        return $this->applySorting($dailySalaries);
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function render()
    {
        return view('livewire.daily-salaries.daily-salaries-list', [
            'dailySalaries' => $this->rows,
        ]);
    }
}
