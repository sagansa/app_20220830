<?php

namespace App\Http\Livewire;

use Image;
use Illuminate\Support\Str;
use App\Models\User;
use Livewire\Component;
use App\Models\Product;
use App\Models\StoreAsset;
use Livewire\WithPagination;
use App\Models\MovementAsset;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class StoreAssetMovementAssetsDetail extends Component
{
    use WithPagination;
    use WithFileUploads;
    use AuthorizesRequests;

    public StoreAsset $storeAsset;
    public MovementAsset $movementAsset;
    public $productsForSelect = [];
    public $usersForSelect = [];
    public $movementAssetImage;
    public $movementAssetQrCode;
    public $uploadIteration = 0;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $image;

    public $modalTitle = 'New MovementAsset';

    protected $rules = [
        'movementAssetImage' => ['nullable', 'image'],
        'movementAssetQrCode' => ['image', 'nullable'],
        'movementAsset.product_id' => ['required', 'exists:products,id'],
        'movementAsset.good_cond_qty' => ['required', 'numeric'],
        'movementAsset.bad_cond_qty' => ['required', 'numeric'],
    ];

    public function mount(StoreAsset $storeAsset)
    {
        $this->storeAsset = $storeAsset;
        $this->productsForSelect = Product::where('material_group_id', '=', '8')
            ->orderBy('name', 'asc')
            ->get()
            ->pluck( 'id', 'product_name');
        $this->usersForSelect = User::pluck('name', 'id');
        $this->resetMovementAssetData();
    }

    public function resetMovementAssetData()
    {
        $this->movementAsset = new MovementAsset();

        $this->movementAssetImage = null;
        $this->movementAssetQrCode = null;
        $this->movementAsset->product_id = null;
        $this->movementAsset->user_id = 'auth()->user()->id';

        $this->dispatchBrowserEvent('refresh');
    }

    public function newMovementAsset()
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.store_asset_movement_assets.new_title');
        $this->resetMovementAssetData();

        $this->showModal();
    }

    public function editMovementAsset(MovementAsset $movementAsset)
    {
        $this->editing = true;
        $this->modalTitle = trans(
            'crud.store_asset_movement_assets.edit_title'
        );
        $this->movementAsset = $movementAsset;

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

        if (!$this->movementAsset->store_asset_id) {
            $this->authorize('create', MovementAsset::class);

            $this->movementAsset->store_asset_id = $this->storeAsset->id;
        } else {
            $this->authorize('update', $this->movementAsset);
        }

        if ($this->movementAssetImage) {
            $this->movementAsset->image = $this->movementAssetImage->store(
                'public'
            );
        }

        if ($this->movementAssetQrCode) {
            $this->movementAsset->qr_code = $this->movementAssetQrCode->store(
                'public'
            );
        }

        $this->movementAsset->save();

        $this->uploadIteration++;

        $this->hideModal();
    }

    public function destroySelected()
    {
        $this->authorize('delete-any', MovementAsset::class);

        collect($this->selected)->each(function (string $id) {
            $movementAsset = MovementAsset::findOrFail($id);

            if ($movementAsset->image) {
                Storage::delete($movementAsset->image);
            }

            if ($movementAsset->qr_code) {
                Storage::delete($movementAsset->qr_code);
            }

            $movementAsset->delete();
        });

        $this->selected = [];
        $this->allSelected = false;

        $this->resetMovementAssetData();
    }

    public function toggleFullSelection()
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->storeAsset->movementAssets as $movementAsset) {
            array_push($this->selected, $movementAsset->id);
        }
    }

    public function render()
    {
        return view('livewire.store-asset-movement-assets-detail', [
            'movementAssets' => $this->storeAsset
                ->movementAssets()
                ->paginate(20),
        ]);
    }
}
