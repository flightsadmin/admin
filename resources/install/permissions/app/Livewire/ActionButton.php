<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ActionButton extends Component
{
    #[Reactive]
    public Product $product;

    public function toggleLike() {
        if(auth()->guest()) {
            return $this->redirect(route('login'), true);
        }
        $user = auth()->user();

        if($user->hasliked($this->product)) {
            $user->likes()->detach($this->product);
            return;
        } 
        $user->likes()->attach($this->product);        
    }

    public function toggleCart() {
        $user = auth()->user();

        if($user->hasAdded($this->product)) {
            $user->cartItems()->detach($this->product);
            return;
        } 
        $user->cartItems()->attach($this->product);
    }

    public function render()
    {
        return view('livewire.shop.products.action-button');
    }
}