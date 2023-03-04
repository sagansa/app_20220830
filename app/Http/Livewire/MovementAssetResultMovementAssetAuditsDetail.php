<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\View\View;
use Livewire\WithPagination;
use App\Models\MovementAsset;
use Livewire\WithFileUploads;
use App\Models\MovementAssetAudit;
use App\Models\MovementAssetResult;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class MovementAssetResultMovementAssetAuditsDetail extends Component
{
    use WithPagination;
    use WithFileUploads;
    use AuthorizesRequests;

    public MovementAssetResult $movementAssetResult;
    public MovementAssetAudit $movementAssetAudit;
    public $movementAssetsForSelect = [];
    public $movementAssetAuditImage;
    public $uploadIteration = 0;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New MovementAssetAudit';

    protected $rules = [
        'movementAssetAuditImage' => ['nullable', 'image', 'max:1024'],
        'movementAssetAudit.movement_asset_id' => [
            'required',
            'exists:movement_assets,id',
        ],
        'movementAssetAudit.good_cond_qty' => ['required', 'numeric'],
        'movementAssetAudit.bad_cond_qty' => ['required', 'numeric'],
    ];

    public function mount(MovementAssetResult $movementAssetResult): void
    {
        $this->movementAssetResult = $movementAssetResult;
        $this->movementAssetsForSelect = MovementAsset::pluck('image', 'id');
        $this->resetMovementAssetAuditData();
    }

    public function resetMovementAssetAuditData(): void
    {
        $this->movementAssetAudit = new MovementAssetAudit();

        $this->movementAssetAuditImage = null;
        $this->movementAssetAudit->movement_asset_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newMovementAssetAudit(): void
    {
        $this->editing = false;
        $this->modalTitle = trans(
            'crud.movement_asset_result_movement_asset_audits.new_title'
        );
        $this->resetMovementAssetAuditData();

        $this->showModal();
    }

    public function editMovementAssetAudit(
        MovementAssetAudit $movementAssetAudit
    ): void {
        $this->editing = true;
        $this->modalTitle = trans(
            'crud.movement_asset_result_movement_asset_audits.edit_title'
        );
        $this->movementAssetAudit = $movementAssetAudit;

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

        if (!$this->movementAssetAudit->movement_asset_result_id) {
            $this->authorize('create', MovementAssetAudit::class);

            $this->movementAssetAudit->movement_asset_result_id =
                $this->movementAssetResult->id;
        } else {
            $this->authorize('update', $this->movementAssetAudit);
        }

        if ($this->movementAssetAuditImage) {
            $this->movementAssetAudit->image = $this->movementAssetAuditImage->store(
                'public'
            );
        }

        $this->movementAssetAudit->save();

        $this->uploadIteration++;

        $this->hideModal();
    }

    public function destroySelected(): void
    {
        $this->authorize('delete-any', MovementAssetAudit::class);

        collect($this->selected)->each(function (string $id) {
            $movementAssetAudit = MovementAssetAudit::findOrFail($id);

            if ($movementAssetAudit->image) {
                Storage::delete($movementAssetAudit->image);
            }

            $movementAssetAudit->delete();
        });

        $this->selected = [];
        $this->allSelected = false;

        $this->resetMovementAssetAuditData();
    }

    public function toggleFullSelection(): void
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach (
            $this->movementAssetResult->movementAssetAudits
            as $movementAssetAudit
        ) {
            array_push($this->selected, $movementAssetAudit->id);
        }
    }

    public function render(): View
    {
        return view(
            'livewire.movement-asset-result-movement-asset-audits-detail',
            [
                'movementAssetAudits' => $this->movementAssetResult
                    ->movementAssetAudits()
                    ->paginate(20),
            ]
        );
    }
}
