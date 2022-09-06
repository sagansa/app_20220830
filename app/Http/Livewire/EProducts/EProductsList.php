<?php

namespace App\Http\Livewire\EProducts;

use App\Http\Livewire\DataTables\WithFilter;
use App\Http\Livewire\DataTables\WithModal;
use App\Models\Cart;
use App\Models\EProduct;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class EProductsList extends Component
{

    use WithPagination, WithModal, WithFilter;

    public $cartProducts = [];

    public function render()
    {
        $eProducts = EProduct::paginate(16)->latest();

        return view('livewire.e-products.e-products-list', [
            'eProducts' => $eProducts,
        ]);
    }

    public function newOrder()
    {
        $this->editing = false;
        // $this->resetOrderData();

        $this->showEditModal = true;
    }
}
