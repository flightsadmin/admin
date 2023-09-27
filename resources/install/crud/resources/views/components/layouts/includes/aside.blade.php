<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="{{ route('home') }}" wire:navigate class="brand-link">
            <img src="{{ asset('storage/assets/img/AdminLTELogo.png') }}" alt="{{ config('admin.appName', 'app.name') }}"
                class="brand-image opacity-75 shadow">
            <span class="brand-text fw-light">{{ config('admin.appName', 'app.name') }}</span>
        </a>
    </div>
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                <li class="nav-header"> DASHBOARD</li>
                @if (config('admin.modules.flights'))
                    <li class="nav-item">
                        <a href="{{ route('admin.flights') }}" wire:navigate class="nav-link">
                            <i class="nav-icon bi bi-airplane-engines-fill"></i>
                            <p>Flights</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.airlines') }}" wire:navigate class="nav-link">
                            <i class="nav-icon bi-database-add"></i>
                            <p>Airlines</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.registrations') }}" wire:navigate class="nav-link">
                            <i class="nav-icon bi-clock-history"></i>
                            <p>Registrations</p>
                        </a>
                    </li>
                    @role('super-admin|admin')
                        <li class="nav-item">
                            <a href="{{ route('admin.schedules') }}" wire:navigate class="nav-link">
                                <i class="nav-icon bi bi-plus-slash-minus"></i>
                                <p>Schedules</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.delays') }}" wire:navigate class="nav-link">
                                <i class="nav-icon bi-journal-code"></i>
                                <p>Delays</p>
                            </a>
                        </li>
                        <li class="nav-header"> ADMIN</li>
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
                    @endrole
                @endif
                @if (config('admin.modules.blog'))
                    <li class="nav-item">
                        <a href="{{ route('admin.posts') }}" wire:navigate class="nav-link">
                            <i class="nav-icon bi bi-file-spreadsheet-fill"></i>
                            <p>Blog Admin</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('blog') }}" wire:navigate class="nav-link">
                            <i class="nav-icon bi bi-file-spreadsheet-fill"></i>
                            <p>Blog Page</p>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
</aside>