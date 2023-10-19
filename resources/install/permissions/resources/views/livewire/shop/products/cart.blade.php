<div>
    @if ($cartItems->count() > 0)
        <h4>Your Cart</h4>
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Count</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $cartTotal = 0;
                @endphp

                @foreach ($cartItems as $item)
                    @php
                        $cartTotal += $item->product->price;
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->product->name }}</td>
                        <td>${{ $item->product->price }}</td>
                        <td><input type="number" style="max-width: 4rem" class="form-control form-control-sm"></td>
                        <td>
                            <a href="" wire:click.prevent="removeFromCart({{ $item->id }})"
                                class="bi bi-trash-fill text-danger"></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="text-end">
            <strong>Total: ${{ $cartTotal }}</strong>
        </div>
    @else
        <h4>Your cart is empty.</h4>
    @endif
</div>
