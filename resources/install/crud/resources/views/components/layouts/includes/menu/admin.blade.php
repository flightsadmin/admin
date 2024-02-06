@role('admin|super-admin')
    <li class="nav-item">
        <a href="{{ route('admin.students') }}" wire:navigate
            class="nav-link {{ Route::is('admin.students') ? 'active' : '' }}">
            <i class="nav-icon bi-people-fill"></i>
            <p>Students</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('admin.parents') }}" wire:navigate
            class="nav-link {{ Route::is('admin.parents') ? 'active' : '' }}">
            <i class="nav-icon bi-shield-shaded"></i>
            <p>Parents</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('admin.teachers') }}" wire:navigate
            class="nav-link {{ Route::is('admin.teachers') ? 'active' : '' }}">
            <i class="nav-icon bi-person"></i>
            <p>Teachers</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('admin.grades') }}" wire:navigate
            class="nav-link {{ Route::is('admin.grades') ? 'active' : '' }}">
            <i class="nav-icon bi-mortarboard"></i>
            <p>Classes</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('admin.timetable') }}"
            class="nav-link {{ Route::is('admin.timetable') ? 'active' : '' }}">
            <i class="nav-icon bi-calendar4-week"></i>
            <p>Timetable</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('admin.schedules') }}" wire:navigate
            class="nav-link {{ Route::is('admin.schedules') ? 'active' : '' }}">
            <i class="nav-icon bi-database-fill-check"></i>
            <p>Schedule</p>
        </a>
    </li>
    @include('components.layouts.includes.menu.general')

    <li class="nav-header"> ADMIN</li>
    <li class="nav-item">
        <a href="{{ route('admin.settings') }}" wire:navigate
            class="nav-link {{ Route::is('admin.settings') ? 'active' : '' }}">
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
