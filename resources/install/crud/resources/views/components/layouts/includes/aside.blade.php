<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="{{ route('home') }}" wire:navigate class="brand-link">
            <img src="{{ asset('storage/assets/img/AdminLTELogo.png') }}"
                alt="{{ config('admin.appName', 'app.name') }}" class="brand-image opacity-75 shadow">
            <span class="brand-text fw-light">{{ config('admin.appName', 'app.name') }}</span>
        </a>
    </div>
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="true">
                <li class="nav-header"> DASHBOARD</li>
                <li class="nav-item">
                    <a href="{{ route('admin.students') }}" wire:navigate class="nav-link">
                        <i class="nav-icon bi bi-people-fill"></i>
                        <p>Students</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.parents') }}" wire:navigate class="nav-link">
                        <i class="nav-icon bi bi-shield-shaded"></i>
                        <p>Parents</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.teachers') }}" wire:navigate class="nav-link">
                        <i class="nav-icon bi bi-person"></i>
                        <p>Teachers</p>
                    </a>
                </li>
                <li class="nav-header"> ADMIN</li>
                <li class="nav-item">
                    <a href="{{ route('admin.settings') }}" wire:navigate
                        class="nav-link {{ request()->is('admin/settings') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-gear"></i>
                        <p>Settings</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-box-arrow-in-right"></i>
                        <p>
                            Auth
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.users') }}" wire:navigate class="nav-link">
                                <i class="nav-icon bi bi-people-fill"></i>
                                <p>Users</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.roles') }}" wire:navigate class="nav-link">
                                <i class="nav-icon bi bi-shield-shaded"></i>
                                <p>Roles</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.permissions') }}" wire:navigate class="nav-link">
                                <i class="nav-icon bi bi-person-fill-lock"></i>
                                <p>Permissions</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>