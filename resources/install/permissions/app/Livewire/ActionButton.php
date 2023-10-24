<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\On;
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
            $this->dispatch('UpdateCart');
            return;
        } 
        $user->likes()->attach($this->product);
        $this->dispatch('UpdateCart');
    }

    public function toggleCart() {
        if(auth()->guest()) {
            return $this->redirect(route('login'), true);
        }
        $user = auth()->user();

        if($user->hasAdded($this->product)) {
            $user->cartItems()->detach($this->product);
            $this->dispatch('UpdateCart');
            return;
        } 
        $user->cartItems()->attach($this->product);
        $this->dispatch('UpdateCart');
    }
    
    #[On('UpdateCart')]
    public function render()
    {
        return view('livewire.shop.products.action-button');
    }
}