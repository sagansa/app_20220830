<?php

namespace App\Http\Livewire\EProducts;

use App\Models\Cart;
use App\Models\EProduct;
use Livewire\Component;

class EProductShow extends Component
{
    public $state = [];

    public function mount(EProduct $eProduct)
	{
		$this->state = $eProduct->toArray();

		$this->eProduct = $eProduct;
	}

    public function render()
    {
        $this->eProduct->subtotals = $this->eProduct->price * $this->eProduct->quantity;

        return view('livewire.e-products.e-product-show');
    }

    public function addToCart()
    {
        Cart::create();
    }
}
