<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    {{-- blade-formatter-disable-next-line --}}
    <title> @hasSection('title') @yield('title') | @endif {{ config('app.name', 'Laravel') }} </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- blade-formatter-disable-next-line --}}
    <meta name="title" content="@hasSection('title') @yield('title') | @endif {{ config('app.name', 'Laravel') }}">
    <meta name="author" content="{{ config('app.name', 'Laravel') }}">
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
    <!--begin::Required Plugin(AdminLTE)-->
    <script>
        const SELECTOR_SIDEBAR_WRAPPER = ".sidebar-wrapper";
        const Default = {
            scrollbarTheme: "os-theme-light",
            scrollbarAutoHide: "leave",
            scrollbarClickScroll: true,
        };

        document.addEventListener("DOMContentLoaded", function() {
            const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
            if (
                sidebarWrapper &&
                typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== "undefined"
            ) {
                OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                    scrollbars: {
                        theme: Default.scrollbarTheme,
                        autoHide: Default.scrollbarAutoHide,
                        clickScroll: Default.scrollbarClickScroll,
                    },
                });
            }
        });
    </script>
</body>

</html>