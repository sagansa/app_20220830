<?php

namespace App\Http\Livewire\MovementAssets;

use App\Models\MovementAsset;
use Livewire\Component;

class MovementAssetsList extends Component
{
    public function render()
    {
        $movementAssets = MovementAsset::query();

        return view('livewire.movement-assets.movement-assets-list', [
            'movementAssets' => $movementAssets,
        ]);
    }
}
