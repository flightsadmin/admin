<?php

namespace App\Livewire;

use App\Models\Cart;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class Carts extends Component
{
    public $cartItems = [];

    public $cart;

    public $taxRate = 0.1;
    
    #[On('UpdateCart')]
    public function render()
    {
        $this->loadCartItems();

        $subtotals = $this->calculateSubtotals();

        $taxes = $subtotals * $this->taxRate;

        $total = $subtotals + $taxes;

        return view('livewire.shop.products.cart', [
            'subtotals' => $subtotals,
            'taxes' => $taxes,
            'total' => $total,
        ]);
    }

    private function loadCartItems()
    {
        $this->cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
    }

    private function calculateSubtotals()
    {
        $subtotals = 0;
        foreach ($this->cartItems as $item) {
            $item->subtotals = $item->product->price * $item->quantity;
            $subtotals += $item->subtotals;
        }
        return $subtotals;
    }
    
    public function removeFromCart($itemId)
    {
        $item = Cart::find($itemId);

        if ($item) {
            $item->delete();
        }

        $this->loadCartItems();
    }

    public function decrement($id) {
       $cartData = Cart::where('product_id', $id)->where('user_id', Auth::id())->first();

       if ($cartData && $cartData->quantity > 1) {
            $cartData->decrement('quantity', 1);
            $this->dispatch(
                'closeModal',
                icon: 'success',
                message: 'Quantity Updated.',
            );
        } else {
            $this->dispatch(
                'closeModal',
                icon: 'error',
                message: 'Quantity must be greater than 1.',
            );
        }
    }
    
    public function increment($id) {
        $cartData = Cart::where('product_id', $id)->where('user_id', Auth::id())->first();
 
        if ($cartData) {
             $cartData->increment('quantity', 1);
             $this->dispatch(
                 'closeModal',
                 icon: 'success',
                 message: 'Quantity Updated.',
             );
         }
     }
}