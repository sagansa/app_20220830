<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\DailySalary;
use App\Models\ClosingStore;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ClosingStoreDailySalariesDetail extends Component
{
    use AuthorizesRequests;

    public ClosingStore $closingStore;
    public DailySalary $dailySalary;
    public $dailySalariesForSelect = [];
    public $daily_salary_id = null;

    public $showingModal = false;
    public $modalTitle = 'New DailySalary';

    protected $rules = [
        'daily_salary_id' => ['required', 'exists:daily_salaries,id'],
    ];

    public function mount(ClosingStore $closingStore)
    {
        $this->closingStore = $closingStore;
        $this->dailySalariesForSelect = DailySalary::pluck('id', 'date');
        $this->resetDailySalaryData();
    }

    public function resetDailySalaryData()
    {
        $this->dailySalary = new DailySalary();

        $this->daily_salary_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newDailySalary()
    {
        $this->modalTitle = trans(
            'crud.closing_store_daily_salaries.new_title'
        );
        $this->resetDailySalaryData();

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

        $this->authorize('create', DailySalary::class);

        $this->closingStore->dailySalaries()->attach($this->dailySalary_id, []);

        $this->hideModal();
    }

    public function detach($dailySalary)
    {
        $this->authorize('delete-any', DailySalary::class);

        $this->closingStore->dailySalaries()->detach($dailySalary);

        $this->resetDailySalaryData();
    }

    public function render()
    {
        $this->dailySalary->totals = 0;

        foreach ($this->closingStore->dailySalaries as $dailySalary) {
            $this->dailySalary->totals += $dailySalary['amount'];
        }

        return view('livewire.closing-store-daily-salaries-detail', [
            'closingStoreDailySalaries' => $this->closingStore
                ->dailySalaries()
                ->withPivot([])
                ->paginate(20),
        ]);
    }
}
