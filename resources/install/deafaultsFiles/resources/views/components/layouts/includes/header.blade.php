<nav class="app-header navbar navbar-expand bg-body">
    <div class="container-fluid">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                    <i class="bi-list"></i>
                </a>
            </li>
            <li class="nav-item d-none d-md-block">
                <a href="{{ url()->current() }}" wire:navigate class="nav-link">@yield('title')</a>
            </li>
        </ul>

        <ul class="navbar-nav ms-auto">
            @includeWhen(config('admin.modules.shop'), 'components.layouts.includes.messages')
            {{-- @includeWhen(config('admin.modules.shop'), 'components.layouts.includes.notifications') --}}
            @if (!request()->is('admin*'))
                <li class="nav-item">
                    <a class="nav-link" wire:navigate
                        href="{{ route(config('admin.adminRoute')) }}">{{ ucwords(config('admin.adminRoute')) }}</a>
                </li>
            @endif
            @if (config('admin.modules.shop'))
                <li class="nav-item">
                    <a class="nav-link" wire:navigate
                        href="{{ route(config('admin.shopRoute')) }}">{{ ucwords(config('admin.shopRoute')) }}</a>
                </li>
            @endif

            @guest
                @if (Route::has('login'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                @endif

                @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @endif
            @else
                <li class="nav-item dropdown user-menu">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                        <img src="{{ asset('storage/' . Auth::user()->photo) }}"
                            class="user-image rounded-circle shadow" alt="User Image">
                        <span class="d-none d-md-inline"> {{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                        <li class="user-header text-bg-primary">
                            <img src="{{ asset('storage/' . Auth::user()->photo) }}"class="rounded-circle shadow"
                                alt="User Image">

                            <p>
                                {{ Auth::user()->name }} - {{ Auth::user()->title }}
                                <small>Member since {{ Auth::user()->created_at->format('M Y') }}</small>
                            </p>
                        </li>
                        <li class="user-footer">
                            <a wire:navigate href="{{ route('admin.users.show', ['id' => auth()->id()]) }}"
                                class="btn btn-sm btn-outline-secondary">Profile</a>
                            <a class="btn btn-sm btn-outline-secondary float-end" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                {{ __('Sign out') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
            @endguest
        </ul>
    </div>
</nav>
