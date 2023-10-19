<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class Carts extends Component
{
    public $cartItems;
    public $productCounts = [];

    public function render()
    {
        $this->cartItems = Cart::where('user_id', Auth::id())->with('product')->get();

        return view('livewire.shop.products.cart');
    }

    public function removeFromCart($id)
    {
        Cart::find($id)->delete();
    }
}
