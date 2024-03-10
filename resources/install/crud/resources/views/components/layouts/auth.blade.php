<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    {{-- blade-formatter-disable-next-line --}}
    <title> @hasSection('title') @yield('title') | @endif {{ setting('site_name') ?? config('app.name') }} </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- blade-formatter-disable-next-line --}}
    <meta name="title" content="@hasSection('title') @yield('title') | @endif {{ setting('site_name') ?? config('app.name') }}">
    <meta name="author" content="{{ setting('site_name') ?? config('app.name') }}">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/js/app.js'])
</head>

<body class="login-page bg-body-secondary">
    <main>
        @yield('content')
    </main>
    @stack('scripts')
</body>

</html>
