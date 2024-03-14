<?php

namespace App\Livewire\Shop;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Carts extends Component
{
    public $cartItems = [], $appliedCoupon = 3, $cartTotal = 0, $couponCode, $discount = 0, $taxRate = 0.1, $message;

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
        $this->reset('message');
        $cart = Cart::with('product')->where('product_id', $id)->where('user_id', auth()->id())->first();

        if ($cart && $cart->product->quantity > 1 && $cart->quantity > 1) {
            $cart->decrement('quantity');
            $cart->product->increment('quantity');
        } else {
            $this->message = $cart->product->name . ' Cannot be Less than ' . $cart->quantity;
        }
    }


    public function increment($id)
    {
        $this->reset('message');
        $cart = Cart::with('product')->where('product_id', $id)->where('user_id', auth()->id())->first();

        if ($cart && $cart->product->quantity < $cart->quantity) {
            $this->message = $cart->product->name . ' Cannot be More than ' . $cart->quantity;
        } else {
            $cart->increment('quantity');
            $cart->product->decrement('quantity');
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

    public function checkout()
    {
        $cart = Cart::with('product')->where('user_id', auth()->id())->get();

        try {
            DB::transaction(function () use ($cart) {
                $order = Order::create([
                    'user_id' => auth()->id(),
                ]);

                foreach ($cart as $cartProduct) {
                    $order->products()->attach($cartProduct->product_id, [
                        'quantity' => $cartProduct->quantity,
                        'price' => $cartProduct->product->price,
                    ]);
                    $order->increment('total_price', $cartProduct->quantity * $cartProduct->product->price);
                    Product::find($cartProduct->product_id)->decrement('quantity', $cartProduct->quantity);
                }

                Cart::where('user_id', auth()->id())->delete();
                $this->dispatch('UpdateCart');
                $this->dispatch(
                    'closeModal',
                    icon: 'success',
                    message: 'Order Placed Successfully.',
                );
            });
        } catch (\Exception $ex) {
            $this->message = "Something went wrong, Try Again";
        }
        $this->dispatch('UpdateCart');
        $this->redirect(route('shop'), true);
    }
}