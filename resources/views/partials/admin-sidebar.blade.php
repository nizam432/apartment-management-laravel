{{-- Dashboard --}}
<li class="nav-item">
    <a href="{{ route('admin.dashboard') }}"
       class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Dashboard</p>
    </a>
</li>

{{-- Building Management --}}
<li class="nav-item {{ request()->routeIs('admin.buildings.index', 'admin.buildings.create', 'admin.buildings.edit') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ request()->routeIs('admin.buildings.index', 'admin.buildings.create', 'admin.buildings.edit') ? 'active' : '' }}">
        <i class="nav-icon fas fa-building"></i>
        <p>Building Management <i class="right fas fa-angle-left"></i></p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('admin.buildings.index') }}"
               class="nav-link {{ request()->routeIs('admin.buildings.index') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>All Buildings</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.buildings.create') }}"
               class="nav-link {{ request()->routeIs('admin.buildings.create') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Add Building</p>
            </a>
        </li>
    </ul>
</li>

{{-- Floor Management --}}
<li class="nav-item {{ request()->routeIs('admin.buildings.floors.*') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ request()->routeIs('admin.buildings.floors.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-layer-group"></i>
        <p>Floor Management <i class="right fas fa-angle-left"></i></p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('admin.floors.index') }}"
               class="nav-link {{ request()->routeIs('admin.floors.index') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>All Floors</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.floors.create') }}"
               class="nav-link {{ request()->routeIs('admin.floors.create') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Add Floor</p>
            </a>
        </li>
    </ul>
</li>

{{-- Flat Management --}}
<li class="nav-item {{ request()->routeIs('admin.flats.*') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ request()->routeIs('admin.flats.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-door-open"></i>
        <p>Flat Management <i class="right fas fa-angle-left"></i></p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('admin.flats.index') }}"
               class="nav-link {{ request()->routeIs('admin.flats.index') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>All Flats</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.flats.create') }}"
               class="nav-link {{ request()->routeIs('admin.flats.create') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Add Flat</p>
            </a>
        </li>
    </ul>
</li>