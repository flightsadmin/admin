<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="{{ setting('site_theme')}}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    {{-- blade-formatter-disable-next-line --}}
    <title> @hasSection('title') @yield('title') | @endif {{ config('admin.appName', 'app.name') }} </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- blade-formatter-disable-next-line --}}
    <meta name="title" content="@hasSection('title') @yield('title') | @endif {{ config('admin.appName', 'app.name') }}">
    <meta name="author" content="{{ config('admin.appName', 'app.name') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.1.0/styles/overlayscrollbars.min.css"
        integrity="sha256-LWLZPJ7X1jJLI5OG5695qDemW1qQ7lNdbTfQ64ylbUY=" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/js/app.js'])
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md shadow-sm">
            <div class="container-fluid px-4">
                <a class="navbar-brand" href="{{ route('home') }}">
                    {{ config('admin.appName', 'app.name') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!--Nav Bar Hooks - Do not delete!!-->
                        @role('super-admin|admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route(config('admin.adminRoute')) }}">{{ ucwords(config('admin.adminRoute'))}}</a>
                        </li>
                        @endrole
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route(config('admin.blogRoute')) }}">{{ ucwords(config('admin.blogRoute'))}}</a>
                        </li>
                        <!-- Authentication Links -->
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
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    @stack('scripts')
</body>
</html>