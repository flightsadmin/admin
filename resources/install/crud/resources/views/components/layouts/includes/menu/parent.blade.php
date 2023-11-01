@role('parent')
    <li class="nav-item">
        <a href="{{ route('parent') }}" wire:navigate
            class="nav-link {{ Route::is('parent*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-people-fill"></i>
            <p>Students</p>
        </a>
    </li>
    @include('components.layouts.includes.menu.general')
@endrole
