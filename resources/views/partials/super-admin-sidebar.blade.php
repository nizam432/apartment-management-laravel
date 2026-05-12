<li class="nav-item {{ request()->routeIs('super-admin.dashboard') ? 'menu-open' : '' }}">
    <a href="{{ route('super-admin.dashboard') }}"
       class="nav-link {{ request()->routeIs('super-admin.dashboard') ? 'active' : '' }}">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Dashboard</p>
    </a>
</li>

<li class="nav-item {{ request()->routeIs('super-admin.admins.*') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ request()->routeIs('super-admin.admins.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-users-cog"></i>
        <p>Admin Management <i class="right fas fa-angle-left"></i></p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('super-admin.admins.index') }}"
               class="nav-link {{ request()->routeIs('super-admin.admins.index') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>All Admins</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('super-admin.admins.create') }}"
               class="nav-link {{ request()->routeIs('super-admin.admins.create') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Add Admin</p>
            </a>
        </li>
    </ul>
</li>

<li class="nav-item {{ request()->routeIs('super-admin.departments.*') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ request()->routeIs('super-admin.departments.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-sitemap"></i>
        <p>Department Management <i class="right fas fa-angle-left"></i></p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('super-admin.departments.index') }}"
               class="nav-link {{ request()->routeIs('super-admin.departments.index') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>All Departments</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('super-admin.departments.create') }}"
               class="nav-link {{ request()->routeIs('super-admin.departments.create') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Add Department</p>
            </a>
        </li>
    </ul>
</li>