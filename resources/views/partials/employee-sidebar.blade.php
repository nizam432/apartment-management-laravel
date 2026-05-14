{{-- Dashboard --}}
<li class="nav-item">
    <a href="{{ route('employee.dashboard') }}"
       class="nav-link {{ request()->routeIs('employee.dashboard') ? 'active' : '' }}">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Dashboard</p>
    </a>
</li>

{{-- Visitor Log --}}
<li class="nav-item {{ request()->routeIs('employee.visitor-logs*') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ request()->routeIs('employee.visitor-logs*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-clipboard-list"></i>
        <p>Visitor Log <i class="right fas fa-angle-left"></i></p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('employee.visitor-logs') }}"
               class="nav-link {{ request()->routeIs('employee.visitor-logs') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>All Visitors</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('employee.visitor-logs.create') }}"
               class="nav-link {{ request()->routeIs('employee.visitor-logs.create') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Add Visitor</p>
            </a>
        </li>
    </ul>
</li>

{{-- Notice Board --}}
<li class="nav-item">
    <a href="{{ route('employee.notices') }}"
       class="nav-link {{ request()->routeIs('employee.notices') ? 'active' : '' }}">
        <i class="nav-icon fas fa-bullhorn"></i>
        <p>Notice Board</p>
    </a>
</li>

{{-- Profile --}}
<li class="nav-item">
    <a href="{{ route('employee.profile') }}"
       class="nav-link {{ request()->routeIs('employee.profile') ? 'active' : '' }}">
        <i class="nav-icon fas fa-user-circle"></i>
        <p>Profile</p>
    </a>
</li>