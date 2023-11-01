@role('parent')
    <li class="nav-item">
        <a href="{{ route('admin.students') }}" wire:navigate
            class="nav-link {{ Route::is('admin.students') ? 'active' : '' }}">
            <i class="nav-icon bi bi-people-fill"></i>
            <p>Students</p>
        </a>
    </li>
    @include('components.layouts.includes.menu.general')
@endrole
