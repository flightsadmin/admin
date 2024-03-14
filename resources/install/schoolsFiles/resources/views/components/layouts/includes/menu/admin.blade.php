@role('admin|super-admin')
    <li class="nav-item">
        <a href="{{ route('admin.students') }}"
            class="nav-link {{ Route::is('admin.students') ? 'active' : '' }}">
            <i class="nav-icon bi-people-fill"></i>
            <p>Students</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('admin.parents') }}"
            class="nav-link {{ Route::is('admin.parents') ? 'active' : '' }}">
            <i class="nav-icon bi-shield-shaded"></i>
            <p>Parents</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('admin.teachers') }}"
            class="nav-link {{ Route::is('admin.teachers') ? 'active' : '' }}">
            <i class="nav-icon bi-person"></i>
            <p>Teachers</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('admin.grades') }}"
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
        <a href="{{ route('admin.schedules') }}"
            class="nav-link {{ Route::is('admin.schedules') ? 'active' : '' }}">
            <i class="nav-icon bi-database-fill-check"></i>
            <p>Schedule</p>
        </a>
    </li>
    @include('components.layouts.includes.menu.general')
@endrole
