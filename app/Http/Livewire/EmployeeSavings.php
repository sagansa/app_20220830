<?php

namespace App\Http\Livewire;

use App\Models\Saving;
use Livewire\Component;
use App\Models\Employee;
use Illuminate\View\View;
use Livewire\WithPagination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EmployeeSavings extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public Employee $employee;
    public Saving $saving;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New Saving';

    protected $rules = [
        'saving.debet_credit' => ['required', 'max:255'],
        'saving.nominal' => ['required', 'numeric', 'min:0'],
    ];

    public function mount(Employee $employee): void
    {
        $this->employee = $employee;
        $this->resetSavingData();
    }

    public function resetSavingData(): void
    {
        $this->saving = new Saving();

        $this->saving->debet_credit = '1';

        $this->dispatchBrowserEvent('refresh');
    }

    public function newSaving(): void
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.employee_savings.new_title');
        $this->resetSavingData();

        $this->showModal();
    }

    public function editSaving(Saving $saving): void
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.employee_savings.edit_title');
        $this->saving = $saving;

        $this->dispatchBrowserEvent('refresh');

        $this->showModal();
    }

    public function showModal(): void
    {
        $this->resetErrorBag();
        $this->showingModal = true;
    }

    public function hideModal(): void
    {
        $this->showingModal = false;
    }

    public function save(): void
    {
        $this->validate();

        if (!$this->saving->employee_id) {
            $this->authorize('create', Saving::class);

            $this->saving->employee_id = $this->employee->id;
        } else {
            $this->authorize('update', $this->saving);
        }

        $this->saving->save();

        $this->hideModal();
    }

    public function destroySelected(): void
    {
        $this->authorize('delete-any', Saving::class);

        Saving::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetSavingData();
    }

    public function toggleFullSelection(): void
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->employee->savings as $saving) {
            array_push($this->selected, $saving->id);
        }
    }

    public function render(): View
    {
        return view('livewire.employee-savings', [
            'savings' => $this->employee->savings()->paginate(20),
        ]);
    }
}
