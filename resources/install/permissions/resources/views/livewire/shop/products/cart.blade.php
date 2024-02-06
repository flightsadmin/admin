<div class="mb-3">
    @if ($cartItems->count() > 0)
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <h4>Your Cart</h4>
                    <span class="text-danger ms-auto">{{ $message }}</span>
                </div>
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cartItems as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->product->name }}</td>
                                <td>${{ $item->product->price }}</td>
                                <td style="max-width: 6rem">
                                    <div class="input-group input-group-sm align-items-center gap-2">
                                        <span class="input-group-btn">
                                            <a href="" wire:click.prevent="decrement({{ $item->product->id }})"><i
                                                    class="bi-dash-circle text-info"></i></a>
                                        </span>
                                        <input disabled type="text" name="quantity" class="form-control form-control-sm text-center"
                                            value="{{ $item->quantity }}">
                                        <span class="input-group-btn">
                                            <a href="" wire:click.prevent="increment({{ $item->product->id }})"><i
                                                    class="bi-plus-circle text-success"></i></a>
                                        </span>
                                    </div>

                                </td>
                                <td>${{ $item->product->price * $item->quantity }}</td>
                                <td>
                                    <a href="" wire:click.prevent="removeFromCart({{ $item->id }})"
                                        class="bi-trash-fill text-danger"></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="mb-3">
                            @if ($appliedCoupon === 1)
                                <div class="text-success">
                                    {{ 'Coupon: ' . $couponCode . ' Applied' }}
                                </div>
                            @elseif ($appliedCoupon === 2)
                                <div class="text-danger">
                                    Invalid Coupon Code
                                </div>
                            @else
                            @endif
                            <form wire:submit.prevent="applyCoupon" class="d-flex gap-2">
                                <input wire:model="couponCode" name="couponCode" class="form-control form-control-sm"
                                    placeholder="Enter Your Coupon">
                                <button type="submit" class="btn btn-sm btn-secondary">Apply</button>
                            </form>
                        </div>
                        <div class="input-group input-group-sm mb-3">
                            <label for="tax" class="input-group-text">Taxes</label>
                            <select wire:model.live="taxRate" class="form-select">
                                <option value="0.0">Choose an option...</option>
                                <option value="0.1"> 10% Tax</option>
                                <option value="0.2"> 20% Tax</option>
                                <option value="0.3"> 30% Tax</option>
                            </select>
                        </div>
                    </div>
                    <div class="text-end">
                        <div><strong>Subtotal:</strong> ${{ number_format($subtotals, 2) }}</div>
                        <div><strong>Taxes ({{ $taxRate * 100 }}%):</strong> ${{ number_format($taxes, 2) }}</div>
                        <div><strong>Discount:</strong> ${{ number_format($discount, 2) }}</div>
                        <div><strong>Total:</strong> ${{ number_format($discounted, 2) }}</div>
                    </div>
                </div>
                <div>
                    <a wire:navigate href="{{ route('shop.checkout') }}">
                        <button type="button" class="btn btn-sm btn-primary mt-3 bi-eye-fill"> View Cart</button>
                    </a>
                    <button wire:click="checkout" class="btn btn-sm btn-primary float-end mt-3 bi-cart4"> Complete Check</button>
                </div>
            </div>
        </div>
    @else
        <div class="mb-3">
            <h4>Your cart is empty.</h4>
        </div>
    @endif
</div>
