@role('student')
    <li class="nav-item">
        <a href="{{ route('admin.grades') }}" wire:navigate
            class="nav-link {{ Route::is('admin.grades') ? 'active' : '' }}">
            <i class="nav-icon bi bi-mortarboard"></i>
            <p>Classes</p>
        </a>
    </li>
    @include('components.layouts.includes.menu.general')
@endrole
