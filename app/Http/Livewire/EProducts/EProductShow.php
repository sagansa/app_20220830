<?php

namespace App\Http\Livewire\EProducts;

use App\Models\Cart;
use App\Models\EProduct;
use Livewire\Component;

class EProductShow extends Component
{
    public $state = [];

    public $e_product_id;
    public $quantity;
    public $user_id;

    protected $rules = [
        'e_product_id' => 'required',
        'quantity' => 'required|min:1',
        'user_id' => 'required',
    ];

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
        $this->validate();

        $cart = Cart::create([
            'e_product_id' => $this->e_product_id,
            'quantity' => $this->quantity,
            'user_id' => auth()->user()->id,
        ]);

        $cart->subtotal = $cart->eProduct->price * $cart->quantity;

        $cart->save();



        return redirect()->route('/');
    }
}
