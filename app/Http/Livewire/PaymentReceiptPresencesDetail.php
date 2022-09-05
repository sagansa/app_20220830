<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Presence;
use App\Models\PaymentReceipt;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
        $this->presencesForSelect = Presence::orderBy('created_by_id', 'asc')
            // ->join('users', 'users.id', '=', 'presences.created_by_id')
            // ->orderBy('users.name', 'asc')
            ->get()
            ->where('payment_type_id', '=', '1')
            ->where('status', '=', '1')
            ->pluck('id', 'presence_name');
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

    public function changeStatus(Presence $presence, $status)
    {
        Validator::make(['status' => $status], [
			'status' => [
				'required',
				Rule::in(Presence::STATUS_BELUM_DIBAYAR, Presence::STATUS_SUDAH_DIBAYAR, Presence::STATUS_TIDAK_VALID),
			],
		])->validate();

		$presence->update(['status' => $status]);

        $this->emit($this->presencesForSelect);

		$this->dispatchBrowserEvent('updated', ['message' => "Status changed to {$status} successfully."]);
    }
}
