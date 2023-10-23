<?php

namespace App\Livewire;

use App\Models\Cart;
use App\Models\Coupon;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class Carts extends Component
{
    public $cartItems = [], $appliedCoupon = 3, $cartTotal = 0, $couponCode, $discount = 0, $taxRate = 0.1;

    #[On('UpdateCart')]
    public function render()
    {
        $this->loadCartItems();

        $subtotals = $this->calculateSubtotals();

        $taxes = $subtotals * $this->taxRate;

        $total = $subtotals + $taxes;

        $totalAfterDiscount = $total - $this->discount;

        return view('livewire.shop.products.cart', [
            'subtotals' => $subtotals,
            'taxes' => $taxes,
            'total' => $total,
            'discounted' => $totalAfterDiscount,
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
        $this->dispatch('UpdateCart');
        $this->loadCartItems();
    }

    public function decrement($id)
    {
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

    public function increment($id)
    {
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

    public function applyCoupon()
    {
        $coupon = Coupon::where('code', $this->couponCode)->first();
        $user = Auth::user();
        if ($coupon) {
            $usedCoupon = $user->coupons->where('id', $coupon->id)->first();
            if (!$usedCoupon) {
                $this->discount = $coupon->discount;
                $user->coupons()->attach($coupon->id, ['used_at' => now()]);
                $this->appliedCoupon = 1;
                $this->dispatch('UpdateCart');
            } else {
                $this->dispatch(
                    'closeModal',
                    icon: 'info',
                    message: 'Coupon Already Used.',
                );
            }
        } else {
            $this->discount = 0;
            $this->appliedCoupon = 2;
            $this->dispatch('UpdateCart');
        }
    }
}