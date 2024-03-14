<?php

namespace App\Livewire\Shop;

use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\On;

class ActionButton extends Component
{
    #[Reactive]
    public Product $product;

    public function toggleLike()
    {
        if (auth()->guest()) {
            return $this->redirect(route('login'), true);
        }
        $user = auth()->user();

        if ($this->product->likes()->where('user_id', $user->id)->exists()) {
            $this->product->likes()->where(['user_id' => $user->id])->delete();
            $this->dispatch('UpdateCart');
            return;
        }
        $this->product->likes()->create(['user_id' => $user->id]);
        $this->dispatch('UpdateCart');
    }

    public function toggleCart()
    {
        if (auth()->guest()) {
            return $this->redirect(route('login'), true);
        }
        $user = auth()->user();

        if ($user->hasAdded($this->product)) {
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