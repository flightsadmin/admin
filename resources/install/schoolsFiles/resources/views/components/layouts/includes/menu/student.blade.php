@role('student')
    <li class="nav-item">
        <a href="{{ route('student') }}" wire:navigate
            class="nav-link {{ Route::is('student*') ? 'active' : '' }}">
            <i class="nav-icon bi-mortarboard"></i>
            <p>Classes</p>
        </a>
    </li>
    @include('components.layouts.includes.menu.general')
@endrole
