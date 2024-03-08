<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="{{ route(config('admin.adminRoute')) }}" wire:navigate class="brand-link">
            <img src="{{ asset('storage/' . setting('site_logo')) }}" alt="{{ config('admin.appName', 'app.name') }}"
                class="brand-image opacity-75 shadow">
            <span class="brand-text fw-light">{{ config('admin.appName', 'app.name') }}</span>
        </a>
    </div>
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="true">
                <li class="nav-header"> DASHBOARD</li>
                @role('super-admin|admin|user')
                    @if (config('admin.modules.flights'))
                        @role('super-admin|admin')
                            <li class="nav-item">
                                <a href="{{ route('admin.schedules') }}" wire:navigate
                                    class="nav-link {{ request()->is('admin/schedules') ? 'active' : '' }}">
                                    <i class="nav-icon bi-plus-slash-minus"></i>
                                    <p>Schedules</p>
                                </a>
                            </li>
                        @endif
                        <li class="nav-header"> ADMIN</li>
                        <li class="nav-item">
                            <a href="{{ route('admin.settings') }}" wire:navigate
                                class="nav-link {{ request()->is('admin/settings') ? 'active' : '' }}">
                                <i class="nav-icon bi-gear"></i>
                                <p>Settings</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi-box-arrow-in-right"></i>
                                <p>
                                    Auth
                                    <i class="nav-arrow bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.users') }}" wire:navigate class="nav-link">
                                        <i class="nav-icon bi-people-fill"></i>
                                        <p>Users</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.roles') }}" wire:navigate class="nav-link">
                                        <i class="nav-icon bi-shield-shaded"></i>
                                        <p>Roles</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.permissions') }}" wire:navigate class="nav-link">
                                        <i class="nav-icon bi-person-fill-lock"></i>
                                        <p>Permissions</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endrole
                @endrole
            </ul>
        </nav>
    </div>
</aside>
