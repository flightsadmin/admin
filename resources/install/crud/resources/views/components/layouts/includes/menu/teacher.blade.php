@role('teacher')
    <li class="nav-item">
        <a href="{{ route('teacher') }}" wire:navigate
            class="nav-link {{ Route::is('teacher*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-mortarboard"></i>
            <p>Teacher</p>
        </a>
    </li>
    @include('components.layouts.includes.menu.general')
@endrole
