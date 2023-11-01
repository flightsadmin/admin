<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="{{ route('home') }}" wire:navigate class="brand-link">
            <img src="{{ asset('storage/' . setting('site_logo')) }}" alt="{{ config('admin.appName', 'app.name') }}"
                class="brand-image opacity-75 shadow">
            <span class="brand-text fw-light">{{ config('admin.appName', 'app.name') }}</span>
        </a>
    </div>
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="true">
                <li class="nav-header"> DASHBOARD</li>
                @includeWhen(auth()->user()->hasRole("admin|super-admin"), "components.layouts.includes.menu.admin")
                @includeWhen(auth()->user()->hasRole("teacher"), "components.layouts.includes.menu.teacher")
                @includeWhen(auth()->user()->hasRole("parent"), "components.layouts.includes.menu.parent")
                @includeWhen(auth()->user()->hasRole("student"), "components.layouts.includes.menu.student")
            </ul>
        </nav>
    </div>
</aside>
