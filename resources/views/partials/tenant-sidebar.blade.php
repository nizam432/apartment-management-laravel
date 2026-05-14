{{-- Dashboard --}}
<li class="nav-item">
    <a href="{{ route('tenant.dashboard') }}"
       class="nav-link {{ request()->routeIs('tenant.dashboard') ? 'active' : '' }}">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Dashboard</p>
    </a>
</li>

{{-- My Flat --}}
<li class="nav-item">
    <a href="{{ route('tenant.flat') }}"
       class="nav-link {{ request()->routeIs('tenant.flat') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>My Flat</p>
    </a>
</li>

{{-- Rent Payments --}}
<li class="nav-item">
    <a href="{{ route('tenant.rent-payments') }}"
       class="nav-link {{ request()->routeIs('tenant.rent-payments') ? 'active' : '' }}">
        <i class="nav-icon fas fa-money-bill-wave"></i>
        <p>Rent Payments</p>
    </a>
</li>

{{-- Utility Bills --}}
<li class="nav-item">
    <a href="{{ route('tenant.utility-bills') }}"
       class="nav-link {{ request()->routeIs('tenant.utility-bills') ? 'active' : '' }}">
        <i class="nav-icon fas fa-file-invoice-dollar"></i>
        <p>Utility Bills</p>
    </a>
</li>

{{-- Complaints --}}
<li class="nav-item {{ request()->routeIs('tenant.complaints*') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ request()->routeIs('tenant.complaints*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-exclamation-circle"></i>
        <p>Complaints <i class="right fas fa-angle-left"></i></p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('tenant.complaints') }}"
               class="nav-link {{ request()->routeIs('tenant.complaints') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>My Complaints</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('tenant.complaints.create') }}"
               class="nav-link {{ request()->routeIs('tenant.complaints.create') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Submit Complaint</p>
            </a>
        </li>
    </ul>
</li>

{{-- Notice Board --}}
<li class="nav-item">
    <a href="{{ route('tenant.notices') }}"
       class="nav-link {{ request()->routeIs('tenant.notices') ? 'active' : '' }}">
        <i class="nav-icon fas fa-bullhorn"></i>
        <p>Notice Board</p>
    </a>
</li>

{{-- Profile --}}
<li class="nav-item">
    <a href="{{ route('tenant.profile') }}"
       class="nav-link {{ request()->routeIs('tenant.profile') ? 'active' : '' }}">
        <i class="nav-icon fas fa-user-circle"></i>
        <p>Profile</p>
    </a>
</li>