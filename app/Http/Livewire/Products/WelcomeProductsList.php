<?php

namespace App\Http\Livewire\Products;

use App\Models\EProduct;
use App\Models\Product;
use Livewire\Component;

class WelcomeProductsList extends Component
{
    public function render()
    {
        $eProducts = EProduct::where('status', '=', '1')->get();

        return view('livewire.products.welcome-products-list', [
            'eProducts' => $eProducts,
        ]);
    }
}
