<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Presence;
use App\Models\ClosingStore;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ClosingStorePresencesDetail extends Component
{
    use AuthorizesRequests;

    public ClosingStore $closingStore;
    public Presence $presence;
    public $presencesForSelect = [];
    public $presence_id = null;

    public $showingModal = false;
    public $modalTitle = 'New Presence';

    protected $rules = [
        'presence_id' => ['required', 'exists:presences,id'],
    ];

    public function mount(ClosingStore $closingStore)
    {
        $this->closingStore = $closingStore;
        $this->presencesForSelect = Presence::pluck('image_in', 'id');
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
        $this->modalTitle = trans('crud.closing_store_presences.new_title');
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

        $this->closingStore->presences()->attach($this->presence_id, []);

        $this->hideModal();
    }

    public function detach($presence)
    {
        $this->authorize('delete-any', Presence::class);

        $this->closingStore->presences()->detach($presence);

        $this->resetPresenceData();
    }

    public function render()
    {
        $this->presence->totals = 0;

        foreach ($this->closingStore->presences as $presence) {
            $this->presence->totals += $presence['amount'];
        }

        return view('livewire.closing-store-presences-detail', [
            'closingStorePresences' => $this->closingStore
                ->presences()
                ->withPivot([])
                ->paginate(20),
        ]);
    }
}
