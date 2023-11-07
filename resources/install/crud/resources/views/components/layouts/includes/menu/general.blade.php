<li class="nav-item">
    <a href="{{ route('admin.notices') }}" wire:navigate
        class="nav-link {{ Route::is('admin.notices') ? 'active' : '' }}">
        <i class="nav-icon bi bi-clipboard2-data-fill"></i>
        <p>Notices</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('admin.timetable') }}" wire:navigate
        class="nav-link {{ Route::is('admin.timetable') ? 'active' : '' }}">
        <i class="nav-icon bi bi-clipboard2-data-fill"></i>
        <p>Timetable</p>
    </a>
</li>