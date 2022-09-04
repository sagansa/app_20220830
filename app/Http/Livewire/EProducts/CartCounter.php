<?php

namespace App\Http\Livewire\EProducts;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CartCounter extends Component
{
    protected $listeners = ['updateCart' => 'render'];

    public function render()
    {
        return view('livewire.e-products.cart-counter', [
            'cartAmount' => Cart::sum('quantity'),
        ]);
    }
}
