<nav class="app-header navbar navbar-expand bg-body">
    <div class="container-fluid">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                    <i class="bi-list"></i>
                </a>
            </li>
            <li class="nav-item d-none d-md-block">
                <a href="{{ route('home') }}" wire:navigate class="nav-link">@yield('title', config('admin.appName', 'app.name'))</a>
            </li>
        </ul>

        <ul class="navbar-nav ms-auto">
            @include('components.layouts.includes.messages')
            {{-- @include('components.layouts.includes.notifications') --}}
            @role('super-admin|admin')
            <li class="nav-item">
                <a class="nav-link" href="{{ route(config('admin.adminRoute')) }}">{{ ucwords(config('admin.adminRoute'))}}</a>
            </li>
            @endrole
            <li class="nav-item">
                <a class="nav-link" href="{{ route(config('admin.shopRoute')) }}">{{ ucwords(config('admin.shopRoute'))}}</a>
            </li>
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
                        <!--begin::User Image-->
                        <li class="user-header text-bg-primary">
                            <img src="{{ asset('storage/' . Auth::user()->photo) }}"class="rounded-circle shadow"
                                alt="User Image">

                            <p>
                                {{ Auth::user()->name }} - {{ Auth::user()->title }}
                                <small>Member since {{ Auth::user()->created_at->format('M Y') }}</small>
                            </p>
                        </li>
                        <!--begin::Menu Body-->
                        <li class="user-body">
                            <!--begin::Row-->
                            <div class="row">
                                <div class="col-4 text-center">
                                    <a href="#">Followers</a>
                                </div>
                                <div class="col-4 text-center">
                                    <a href="#">Sales</a>
                                </div>
                                <div class="col-4 text-center">
                                    <a href="{{ route('admin.users') }}">Friends</a>
                                </div>
                            </div>
                        </li>
                        <!--begin::Menu Footer-->
                        <li class="user-footer">
                            <a href="#" class="btn btn-default btn-flat">Profile</a>
                            <a class="btn btn-default btn-flat float-end" href="{{ route('logout') }}"
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