<li class="nav-item dropdown">
    <a class="nav-link" data-bs-toggle="dropdown" href="#">
        <i class="bi bi-cart4"></i>
        <span class="navbar-badge badge text-bg-danger"> @livewire('cart_count')</span>
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
        <a href="#" class="dropdown-item">
            <!--begin::Message-->
            <div class="d-flex">
                <p>You have ( @livewire('cart_count') ) items in your cart</p>
            </div>
        </a>
        <div class="dropdown-divider"></div>
        @auth
        <a wire:navigate href="{{ route('shop.checkout') }}" class="dropdown-item dropdown-footer">Checkout</a>
        @endauth
    </div>
</li>
