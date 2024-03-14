<li class="nav-item dropdown">
    <a class="nav-link" data-bs-toggle="dropdown" href="#">
        <i class="bi-cart4"></i>
        <span class="navbar-badge badge text-bg-danger"> @livewire('shop.cart_count')</span>
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
        <a wire:navigate href="{{ route('shop.checkout') }}" class="dropdown-item">
            <div class="d-flex ">
                <p> You have ( @livewire('shop.cart_count') ) items in your cart</p>
            </div>
        </a>
        <div class="dropdown-divider"></div>
        @auth
            <a wire:navigate href="{{ route('shop.checkout') }}" class="dropdown-item dropdown-footer">Checkout <i
                    class="bi-cart-check-fill"></i></a>
        @endauth
    </div>
</li>
