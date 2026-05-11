<li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'menu-open' : '' }}">
    <a href="{{ route('admin.dashboard') }}"
       class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Dashboard</p>
    </a>
</li>

<li class="nav-item {{ request()->routeIs('admin.buildings.*') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ request()->routeIs('admin.buildings.*') ? 'active' : '' }}">
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