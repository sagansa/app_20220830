<?php

namespace App\Http\Livewire;

use App\Models\Salary;
use Livewire\Component;
use App\Models\Presence;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class MonthlySalaryPresencesDetail extends Component
{
    use AuthorizesRequests;

    public Salary $salary;
    public Presence $presence;
    public $presencesForSelect = [];
    public $presence_id = null;

    public $showingModal = false;
    public $modalTitle = 'New Presence';

    protected $rules = [
        'presence_id' => ['required', 'exists:presences,id'],
    ];

    public function mount(Salary $salary)
    {
        $this->salary = $salary;
        $this->presencesForSelect = Presence::pluck('date', 'id');
        $this->resetPresenceData();
    }

    public function resetPresenceData()
    {
        $this->presence = new Presence();

        $this->presence_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newPresence()
    {
        $this->modalTitle = trans('crud.monthly_salary_presences.new_title');
        $this->resetPresenceData();

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

        $this->authorize('create', Presence::class);

        $this->salary->presences()->attach($this->presence_id, []);

        $this->hideModal();
    }

    public function detach($presence)
    {
        $this->authorize('delete-any', Presence::class);

        $this->salary->presences()->detach($presence);

        $this->resetPresenceData();
    }

    public function render()
    {
        return view('livewire.monthly-salary-presences-detail', [
            'monthlySalaryPresences' => $this->salary
                ->presences()
                ->withPivot([])
                ->paginate(20),
        ]);
    }
}
