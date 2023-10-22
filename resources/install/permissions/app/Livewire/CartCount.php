<?php

namespace App\Livewire;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class CartCount extends Component
{
    public $cartCount = 0;

    #[On("UpdateCart")]
    public function render()
    {
        if (auth()->guest()) {
            $this->cartCount = 0;
        } else {
            $this->cartCount = Cart::where("user_id", auth()->user()->id)->count();
        }
        return view('livewire.shop.products.cart-count', [
            'cartCount' => $this->cartCount
        ]);
    }
}
