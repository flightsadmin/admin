<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    {{-- blade-formatter-disable-next-line --}}
    <title> @hasSection('title') @yield('title') | @endif {{ config('admin.appName', 'app.name') }} </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- blade-formatter-disable-next-line --}}
    <meta name="title" content="@hasSection('title') @yield('title') | @endif {{ config('admin.appName', 'app.name') }}">
    <meta name="author" content="{{ config('admin.appName', 'app.name') }}">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/js/app.js'])
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
        @include('components.layouts.includes.header')
        @include('components.layouts.includes.aside')
        <main class="app-main py-2">
            <div class="app-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </main>
        @include('components.layouts.includes.footer')
    </div>

    @stack('scripts')
</body>

</html>
