<?php

namespace App\Http\Livewire\Selects;

use App\Models\Product as ModelsProduct;
use Livewire\Component;

class Product extends Component
{
    public $AllProducts;

    public $selectedProductId;

    protected $rules = [
        'selectedProductId' => ['required', 'exists:products,id'],
    ];

    public function mount($chargerLocation): void
    {
        $this->clearData();
        $this->fillAllProducts();

        if (is_null($chargerLocation)) {
            return;
        }

        // $chargerLocation = ChargerLocation::findOrFail($chargerLocation);

        $this->selectedProductId = $chargerLocation->province_id;

    }

    public function fillAllProducts(): void
    {
        $this->AllProducts = ModelsProduct::all()->pluck('name', 'id');
    }

    public function clearData(): void
    {
        $this->AllProducts = null;

        $this->selectedProductId = null;
    }

    public function render()
    {
        return view('livewire.selects.product');
    }
}
