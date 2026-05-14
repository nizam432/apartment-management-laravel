{{-- Dashboard --}}
<li class="nav-item">
    <a href="{{ route('owner.dashboard') }}"
       class="nav-link {{ request()->routeIs('owner.dashboard') ? 'active' : '' }}">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Dashboard</p>
    </a>
</li>

{{-- My Flats --}}
<li class="nav-item">
    <a href="{{ route('owner.flats') }}"
       class="nav-link {{ request()->routeIs('owner.flats') ? 'active' : '' }}">
        <i class="nav-icon fas fa-door-open"></i>
        <p>My Flats</p>
    </a>
</li>

{{-- Tenants --}}
<li class="nav-item">
    <a href="{{ route('owner.tenants') }}"
       class="nav-link {{ request()->routeIs('owner.tenants') ? 'active' : '' }}">
        <i class="nav-icon fas fa-users"></i>
        <p>Tenants</p>
    </a>
</li>

{{-- Rent Payments --}}
<li class="nav-item">
    <a href="{{ route('owner.rent-payments') }}"
       class="nav-link {{ request()->routeIs('owner.rent-payments') ? 'active' : '' }}">
        <i class="nav-icon fas fa-money-bill-wave"></i>
        <p>Rent Payments</p>
    </a>
</li>

{{-- Utility Bills --}}
<li class="nav-item">
    <a href="{{ route('owner.utility-bills') }}"
       class="nav-link {{ request()->routeIs('owner.utility-bills') ? 'active' : '' }}">
        <i class="nav-icon fas fa-file-invoice-dollar"></i>
        <p>Utility Bills</p>
    </a>
</li>

{{-- Complaints --}}
<li class="nav-item">
    <a href="{{ route('owner.complaints') }}"
       class="nav-link {{ request()->routeIs('owner.complaints') ? 'active' : '' }}">
        <i class="nav-icon fas fa-exclamation-circle"></i>
        <p>Complaints</p>
    </a>
</li>

{{-- Visitor Log --}}
<li class="nav-item">
    <a href="{{ route('owner.visitor-logs') }}"
       class="nav-link {{ request()->routeIs('owner.visitor-logs') ? 'active' : '' }}">
        <i class="nav-icon fas fa-clipboard-list"></i>
        <p>Visitor Log</p>
    </a>
</li>

{{-- Notice Board --}}
<li class="nav-item">
    <a href="{{ route('owner.notices') }}"
       class="nav-link {{ request()->routeIs('owner.notices') ? 'active' : '' }}">
        <i class="nav-icon fas fa-bullhorn"></i>
        <p>Notice Board</p>
    </a>
</li>

{{-- Profile --}}
<li class="nav-item">
    <a href="{{ route('owner.profile') }}"
       class="nav-link {{ request()->routeIs('owner.profile') ? 'active' : '' }}">
        <i class="nav-icon fas fa-user-circle"></i>
        <p>Profile</p>
    </a>
</li>