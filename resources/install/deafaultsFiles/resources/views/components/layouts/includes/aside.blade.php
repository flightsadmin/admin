<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="{{ route(config('admin.adminRoute')) }}" class="brand-link">
            <img src="{{ asset('storage/' . setting('site_logo')) }}" alt="{{ setting('site_name') ?? config('app.name') }}"
                class="brand-image opacity-75 shadow">
            <span class="brand-text fw-light">{{ setting('site_name') ?? config('app.name') }}</span>
        </a>
    </div>
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="true">
                @role('super-admin|admin|user')
                    @if (config('admin.modules.flights'))
                        <li class="nav-header"> DASHBOARD</li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi-airplane-engines-fill"></i>
                                <p>
                                    Flights
                                    <i class="nav-arrow bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.flights') }}"
                                        class="nav-link {{ request()->is('admin/flights') ? 'active' : '' }}">
                                        <i class="nav-icon bi-airplane-engines-fill"></i>
                                        <p>Flights</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.airlines') }}"
                                        class="nav-link {{ request()->is('admin/airlines') ? 'active' : '' }}">
                                        <i class="nav-icon bi-database-add"></i>
                                        <p>Airlines</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.registrations') }}"
                                        class="nav-link {{ request()->is('admin/registrations') ? 'active' : '' }}">
                                        <i class="nav-icon bi-clock-history"></i>
                                        <p>Registrations</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.schedules') }}"
                                        class="nav-link {{ request()->is('admin/schedules') ? 'active' : '' }}">
                                        <i class="nav-icon bi-plus-slash-minus"></i>
                                        <p>Schedules</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.delays') }}"
                                        class="nav-link {{ request()->is('admin/delays') ? 'active' : '' }}">
                                        <i class="nav-icon bi-journal-code"></i>
                                        <p>Delays</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.services') }}"
                                        class="nav-link {{ request()->is('admin/services') ? 'active' : '' }}">
                                        <i class="nav-icon bi-database-fill"></i>
                                        <p>Services</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    @if (config('admin.modules.school'))
                        <li class="nav-header"> SCHOOL</li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi-mortarboard"></i>
                                <p>
                                    School
                                    <i class="nav-arrow bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @includeWhen(auth()->user()->hasRole('super-admin'), 'components.layouts.includes.menu.admin')
                                @includeWhen(auth()->user()->hasRole('admin'), 'components.layouts.includes.menu.admin')
                                @includeWhen(auth()->user()->hasRole('principal'), 'components.layouts.includes.menu.principal')
                                @includeWhen(auth()->user()->hasRole('teacher'), 'components.layouts.includes.menu.teacher')
                                @includeWhen(auth()->user()->hasRole('parent'), 'components.layouts.includes.menu.parent')
                                @includeWhen(auth()->user()->hasRole('student'), 'components.layouts.includes.menu.student')
                            </ul>
                        </li>
                    @endif
                    @if (config('admin.modules.rosters'))
                        <li class="nav-header"> ROSTER</li>
                        <li class="nav-item">
                            <a href="{{ route('admin.rosters') }}"
                                class="nav-link {{ request()->is('admin/rosters') ? 'active' : '' }}">
                                <i class="nav-icon bi-plus-slash-minus"></i>
                                <p>Rosters</p>
                            </a>
                        </li>
                    @endif

                    @if (config('admin.modules.blog'))
                        <li class="nav-header"> BLOG</li>
                        <li class="nav-item">
                            <a href="{{ route('admin.blog') }}"
                                class="nav-link {{ request()->is('admin/blog') ? 'active' : '' }}">
                                <i class="nav-icon bi-file-spreadsheet-fill"></i>
                                <p>{{ ucwords(config('admin.blogRoute')) }} Admin</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('blog') }}" class="nav-link">
                                <i class="nav-icon bi-newspaper"></i>
                                <p>{{ ucwords(config('admin.blogRoute')) }} Page</p>
                            </a>
                        </li>
                    @endif

                    @if (config('admin.modules.shop'))
                        <li class="nav-header"> SHOP</li>
                        <li class="nav-item">
                            <a href="{{ route('admin.shop') }}"
                                class="nav-link {{ request()->is('admin/shop') ? 'active' : '' }}">
                                <i class="nav-icon bi-file-spreadsheet-fill"></i>
                                <p>{{ ucwords(config('admin.shopRoute')) }} Admin</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('shop') }}" class="nav-link">
                                <i class="nav-icon bi-newspaper"></i>
                                <p>{{ ucwords(config('admin.shopRoute')) }} Page</p>
                            </a>
                        </li>
                    @endif

                    <li class="nav-header"> ADMIN</li>
                    <li class="nav-item">
                        <a href="{{ route('admin.settings') }}"
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
                                <a href="{{ route('admin.users') }}" class="nav-link">
                                    <i class="nav-icon bi-people-fill"></i>
                                    <p>Users</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.roles') }}" class="nav-link">
                                    <i class="nav-icon bi-shield-shaded"></i>
                                    <p>Roles</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.permissions') }}" class="nav-link">
                                    <i class="nav-icon bi-person-fill-lock"></i>
                                    <p>Permissions</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endrole
            </ul>
        </nav>
    </div>
</aside>
