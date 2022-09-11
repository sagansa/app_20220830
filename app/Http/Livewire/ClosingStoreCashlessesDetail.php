<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Cashless;
use Livewire\WithPagination;
use App\Models\ClosingStore;
use Livewire\WithFileUploads;
use App\Models\AccountCashless;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Image;
use Illuminate\Support\Str;

class ClosingStoreCashlessesDetail extends Component
{
    use WithPagination;
    use WithFileUploads;
    use AuthorizesRequests;

    public ClosingStore $closingStore;
    public Cashless $cashless;
    public $accountCashlessesForSelect = [];
    public $cashlessImage;
    public $cashlessImageCanceled;
    public $uploadIteration = 0;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New Cashless';

    protected $rules = [
        'cashlessImage' => ['nullable', 'image'],
        'cashless.account_cashless_id' => [
            'required',
            'exists:account_cashlesses,id',
        ],
        'cashless.bruto_apl' => ['required', 'numeric', 'min:0'],
        'cashless.netto_apl' => ['nullable', 'numeric', 'min:0'],
        'cashlessImageCanceled' => ['image', 'nullable'],
        'cashless.canceled' => ['required', 'numeric', 'min:0'],
        'cashless.bruto_real' => ['nullable', 'numeric', 'min:0'],
        'cashless.netto_real' => ['nullable', 'numeric', 'min:0'],
    ];

    public function mount(ClosingStore $closingStore)
    {
        $this->closingStore = $closingStore;
        $this->accountCashlessesForSelect = AccountCashless::where('store_id', $this->closingStore->store_id)
            ->get()
            ->pluck('id', 'account_cashless_name');
        $this->resetCashlessData();
    }

    public function resetCashlessData()
    {
        $this->cashless = new Cashless();

        $this->cashlessImage = null;
        $this->cashlessImageCanceled = null;
        $this->cashless->account_cashless_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newCashless()
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.closing_store_cashlesses.new_title');
        $this->resetCashlessData();

        $this->showModal();
    }

    public function editCashless(Cashless $cashless)
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.closing_store_cashlesses.edit_title');
        $this->cashless = $cashless;

        $this->dispatchBrowserEvent('refresh');

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

        if (!$this->cashless->closing_store_id) {
            $this->authorize('create', Cashless::class);

            $this->cashless->closing_store_id = $this->closingStore->id;
        } else {
            $this->authorize('update', $this->cashless);
        }

        if ($this->cashlessImage) {
            // $this->cashless->image = $this->cashlessImage->store('public');

            $image = $this->cashlessImage;
            $imageName = Str::random() . '.' . $image->getClientOriginalExtension();
            $imageImg = Image::make($image->getRealPath())->resize(400, 400, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->encode('jpg', 65);
            $imageImg->stream();
            Storage::disk('public')->put('images/cashless' . '/' . $imageName, $imageImg);
        }

        if ($this->cashlessImageCanceled) {
            // $this->cashless->image_canceled = $this->cashlessImageCanceled->store(
            //     'public'
            // );

            $image = $this->cashlessImageCanceled;
            $imageName = Str::random() . '.' . $image->getClientOriginalExtension();
            $imageImg = Image::make($image->getRealPath())->resize(400, 400, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->encode('jpg', 65);
            $imageImg->stream();
            Storage::disk('public')->put('images/cashless-canceled' . '/' . $imageName, $imageImg);
        }

        $this->cashless->save();

        $this->uploadIteration++;

        $this->hideModal();
    }

    public function destroySelected()
    {
        $this->authorize('delete-any', Cashless::class);

        collect($this->selected)->each(function (string $id) {
            $cashless = Cashless::findOrFail($id);

            if ($cashless->image) {
                Storage::delete($cashless->image);
            }

            if ($cashless->image_canceled) {
                Storage::delete($cashless->image_canceled);
            }

            $cashless->delete();
        });

        $this->selected = [];
        $this->allSelected = false;

        $this->resetCashlessData();
    }

    public function toggleFullSelection()
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->closingStore->cashlesses as $cashless) {
            array_push($this->selected, $cashless->id);
        }
    }

    public function render()
    {
        return view('livewire.closing-store-cashlesses-detail', [
            'cashlesses' => $this->closingStore->cashlesses()->paginate(20),
        ]);
    }
}
