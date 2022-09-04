<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Presence;
use App\Models\PaymentReceipt;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PaymentReceiptPresencesDetail extends Component
{
    use AuthorizesRequests;

    public PaymentReceipt $paymentReceipt;
    public Presence $presence;
    public $presencesForSelect = [];
    public $presence_id = null;

    public $showingModal = false;
    public $modalTitle = 'New Presence';

    protected $rules = [
        'presence_id' => ['required', 'exists:presences,id'],
    ];

    public function mount(PaymentReceipt $paymentReceipt)
    {
        $this->paymentReceipt = $paymentReceipt;
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
        $this->modalTitle = trans('crud.payment_receipt_presences.new_title');
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

        $this->paymentReceipt->presences()->attach($this->presence_id, []);

        $this->hideModal();
    }

    public function detach($presence)
    {
        $this->authorize('delete-any', Presence::class);

        $this->paymentReceipt->presences()->detach($presence);

        $this->resetPresenceData();
    }

    public function render()
    {
        return view('livewire.payment-receipt-presences-detail', [
            'paymentReceiptPresences' => $this->paymentReceipt
                ->presences()
                ->withPivot([])
                ->paginate(20),
        ]);
    }
}
