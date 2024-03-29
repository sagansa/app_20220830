<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Employee;
use Illuminate\View\View;
use Livewire\WithPagination;
use App\Models\WorkingExperience;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EmployeeWorkingExperiences extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public Employee $employee;
    public WorkingExperience $workingExperience;
    public $workingExperienceFromDate;
    public $workingExperienceUntilDate;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New WorkingExperience';

    protected $rules = [
        'workingExperience.place' => ['required', 'max:255', 'string'],
        'workingExperience.position' => ['required', 'max:255', 'string'],
        'workingExperience.salary_per_month' => [
            'required',
            'min:0',
            'integer',
        ],
        'workingExperience.previous_boss_name' => [
            'nullable',
            'max:255',
            'string',
        ],
        'workingExperience.previous_boss_no' => [
            'nullable',
            'numeric',
            'digits_between:8,16',
            'min:0',
        ],
        'workingExperienceFromDate' => ['required', 'date'],
        'workingExperienceUntilDate' => ['required', 'date'],
        'workingExperience.reason' => ['required', 'string'],
    ];

    public function mount(Employee $employee): void
    {
        $this->employee = $employee;
        $this->resetWorkingExperienceData();
    }

    public function resetWorkingExperienceData(): void
    {
        $this->workingExperience = new WorkingExperience();

        $this->workingExperienceFromDate = null;
        $this->workingExperienceUntilDate = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newWorkingExperience(): void
    {
        $this->editing = false;
        $this->modalTitle = trans(
            'crud.employee_working_experiences.new_title'
        );
        $this->resetWorkingExperienceData();

        $this->showModal();
    }

    public function editWorkingExperience(
        WorkingExperience $workingExperience
    ): void {
        $this->editing = true;
        $this->modalTitle = trans(
            'crud.employee_working_experiences.edit_title'
        );
        $this->workingExperience = $workingExperience;

        $this->workingExperienceFromDate = optional(
            $this->workingExperience->from_date
        )->format('Y-m-d');
        $this->workingExperienceUntilDate = optional(
            $this->workingExperience->until_date
        )->format('Y-m-d');

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
        if (!$this->workingExperience->employee_id) {
            $this->validate();
        } else {
            $this->validate([
                'workingExperience.place' => ['required', 'max:255', 'string'],
                'workingExperience.position' => [
                    'required',
                    'max:255',
                    'string',
                ],
                'workingExperience.salary_per_month' => [
                    'required',
                    'integer',
                    'min:0',
                ],
                'workingExperience.previous_boss_name' => [
                    'nullable',
                    'max:255',
                    'string',
                ],
                'workingExperience.previous_boss_no' => [
                    'nullable',
                    'numeric',
                    'digits_between:8,16',
                    'min:0',
                ],
                'workingExperienceFromDate' => ['required', 'date'],
                'workingExperienceUntilDate' => ['required', 'date'],
                'workingExperience.reason' => ['required', 'string'],
            ]);
        }

        if (!$this->workingExperience->employee_id) {
            $this->authorize('create', WorkingExperience::class);

            $this->workingExperience->employee_id = $this->employee->id;
        } else {
            $this->authorize('update', $this->workingExperience);
        }

        $this->workingExperience->from_date = \Carbon\Carbon::make(
            $this->workingExperienceFromDate
        );
        $this->workingExperience->until_date = \Carbon\Carbon::make(
            $this->workingExperienceUntilDate
        );

        $this->workingExperience->save();

        $this->hideModal();
    }

    public function destroySelected(): void
    {
        $this->authorize('delete-any', WorkingExperience::class);

        WorkingExperience::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetWorkingExperienceData();
    }

    public function toggleFullSelection(): void
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->employee->workingExperiences as $workingExperience) {
            array_push($this->selected, $workingExperience->id);
        }
    }

    public function render(): View
    {
        return view('livewire.employee-working-experiences', [
            'workingExperiences' => $this->employee
                ->workingExperiences()
                ->paginate(20),
        ]);
    }
}
