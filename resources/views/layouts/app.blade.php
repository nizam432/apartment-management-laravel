<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Apartment Management System')</title>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
    <!-- Custom CSS -->
    <style>
        body { font-size: 15px; }
        .table td, .table th { font-size: 14px; padding: 10px 12px; }
        .card-title { font-size: 16px; }
        .btn { font-size: 13px; padding: 6px 14px; }
        .badge { font-size: 12px; }
        .breadcrumb-item { font-size: 13px; }
        .main-header .navbar-nav .nav-link { font-size: 14px; }
        h1.m-0 { font-size: 22px; }
        .form-control { font-size: 14px; padding: 8px 12px; height: auto; }
        .form-group label { font-size: 14px; font-weight: 600; margin-bottom: 5px; }
        .card-body { padding: 20px; }
        .card-header { padding: 12px 20px; }
        select.form-control { height: auto !important; }

        /* ── Dark Theme (default) ── */
        body.dark-theme .main-sidebar { background: #1a2035 !important; box-shadow: 2px 0 8px rgba(0,0,0,0.3); }
        body.dark-theme .sidebar-dark-primary { background: #1a2035 !important; }
        body.dark-theme .brand-link { padding: 16px 15px !important; border-bottom: 1px solid rgba(255,255,255,0.08) !important; background: #141929 !important; }
        body.dark-theme .brand-text { font-size: 17px !important; font-weight: 700 !important; color: #fff !important; }
        body.dark-theme .nav-sidebar > .nav-item > .nav-link { color: #a8b4c8 !important; border-radius: 8px !important; padding: 10px 14px !important; transition: all 0.25s; }
        body.dark-theme .nav-sidebar > .nav-item > .nav-link:hover { background: rgba(255,255,255,0.07) !important; color: #fff !important; }
        body.dark-theme .nav-sidebar > .nav-item > .nav-link.active { background: linear-gradient(135deg,#007bff,#0056d2) !important; color: #fff !important; box-shadow: 0 4px 12px rgba(0,123,255,0.35); }
        body.dark-theme .nav-treeview { background: rgba(0,0,0,0.15) !important; border-radius: 6px; }
        body.dark-theme .nav-treeview .nav-link { padding: 7px 12px 7px 35px !important; color: #8a9bb5 !important; border-radius: 6px !important; font-size: 13px !important; }
        body.dark-theme .nav-treeview .nav-link:hover { color: #fff !important; background: rgba(255,255,255,0.06) !important; }
        body.dark-theme .nav-treeview .nav-link.active { color: #4d9fff !important; background: rgba(0,123,255,0.15) !important; }

        /* ── Light Theme ── */
        body.light-theme .main-sidebar { background: #ffffff !important; box-shadow: 2px 0 12px rgba(0,0,0,0.1); }
        body.light-theme .sidebar-dark-primary { background: #ffffff !important; }
        body.light-theme .brand-link { padding: 16px 15px !important; border-bottom: 1px solid #e8ecf0 !important; background: #f4f6f9 !important; }
        body.light-theme .brand-text { font-size: 17px !important; font-weight: 700 !important; color: #2d3748 !important; }
        body.light-theme .brand-link .fas { color: #007bff !important; }
        body.light-theme .nav-sidebar > .nav-item > .nav-link { color: #4a5568 !important; border-radius: 8px !important; padding: 10px 14px !important; transition: all 0.25s; }
        body.light-theme .nav-sidebar > .nav-item > .nav-link:hover { background: #eef2ff !important; color: #007bff !important; }
        body.light-theme .nav-sidebar > .nav-item > .nav-link.active { background: linear-gradient(135deg,#007bff,#0056d2) !important; color: #fff !important; box-shadow: 0 4px 12px rgba(0,123,255,0.25); }
        body.light-theme .nav-sidebar .nav-icon { color: #718096 !important; }
        body.light-theme .nav-sidebar > .nav-item > .nav-link.active .nav-icon { color: #fff !important; }
        body.light-theme .nav-treeview { background: #f8fafc !important; border-radius: 6px; }
        body.light-theme .nav-treeview .nav-link { padding: 7px 12px 7px 35px !important; color: #718096 !important; border-radius: 6px !important; font-size: 13px !important; }
        body.light-theme .nav-treeview .nav-link:hover { color: #007bff !important; background: #eef2ff !important; }
        body.light-theme .nav-treeview .nav-link.active { color: #007bff !important; background: #e8f0fe !important; font-weight: 600; }
        body.light-theme .sidebar { background: #fff; }

        /* ── Body Dark Theme ── */
        body.dark-theme { background: #1a1f2e !important; }
        body.dark-theme .content-wrapper { background: #1a1f2e !important; }
        body.dark-theme .main-header { background: #212840 !important; border-bottom: 1px solid rgba(255,255,255,0.08) !important; }
        body.dark-theme .main-header .nav-link { color: #a8b4c8 !important; }
        body.dark-theme .main-header .nav-link:hover { color: #fff !important; }
        body.dark-theme .content-header h1 { color: #e2e8f0 !important; }
        body.dark-theme .breadcrumb { background: transparent !important; }
        body.dark-theme .breadcrumb-item a { color: #7a9cc7 !important; }
        body.dark-theme .breadcrumb-item.active { color: #a8b4c8 !important; }
        body.dark-theme .breadcrumb-item + .breadcrumb-item::before { color: #4a5568 !important; }

        /* Cards dark */
        body.dark-theme .card { background: #252d3d !important; border: 1px solid rgba(255,255,255,0.06) !important; box-shadow: 0 2px 12px rgba(0,0,0,0.3) !important; }
        body.dark-theme .card-header { background: #2a3347 !important; border-bottom: 1px solid rgba(255,255,255,0.06) !important; }
        body.dark-theme .card-title { color: #e2e8f0 !important; }
        body.dark-theme .card-footer { background: #2a3347 !important; border-top: 1px solid rgba(255,255,255,0.06) !important; }

        /* Table dark */
        body.dark-theme .table { color: #cbd5e0 !important; }
        body.dark-theme .table thead th { background: #2a3347 !important; color: #a8b4c8 !important; border-color: rgba(255,255,255,0.06) !important; }
        body.dark-theme .table td { border-color: rgba(255,255,255,0.06) !important; color: #cbd5e0 !important; }
        body.dark-theme .table-hover tbody tr:hover { background: rgba(255,255,255,0.04) !important; }

        /* Forms dark */
        body.dark-theme .form-control { background: #1e2636 !important; border-color: rgba(255,255,255,0.1) !important; color: #e2e8f0 !important; }
        body.dark-theme .form-control:focus { background: #1e2636 !important; border-color: #007bff !important; color: #fff !important; }
        body.dark-theme .form-group label { color: #a8b4c8 !important; }
        body.dark-theme .input-group-text { background: #2a3347 !important; border-color: rgba(255,255,255,0.1) !important; color: #a8b4c8 !important; }

        /* Footer dark */
        body.dark-theme .main-footer { background: #212840 !important; border-top: 1px solid rgba(255,255,255,0.08) !important; color: #a8b4c8 !important; }

        /* ── Body Light Theme ── */
        body.light-theme { background: #f4f6f9 !important; }
        body.light-theme .content-wrapper { background: #f4f6f9 !important; }
        body.light-theme .main-header { background: #fff !important; border-bottom: 1px solid #e8ecf0 !important; }
        body.light-theme .main-footer { background: #fff !important; border-top: 1px solid #e8ecf0 !important; }
        .nav-sidebar .nav-icon { font-size: 15px !important; width: 22px; text-align: center; margin-right: 8px; }
        .nav-sidebar .nav-link p { font-size: 13.5px; font-weight: 500; }
        .nav-sidebar > .nav-item { margin: 3px 10px; }
        .nav-treeview .nav-item { margin: 1px 5px; }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    {{-- Navbar --}}
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            {{-- Dark/Light Toggle --}}
            <li class="nav-item">
                <a class="nav-link" href="#" id="theme-toggle" title="Toggle Theme">
                    <i class="fas fa-moon" id="theme-icon"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="far fa-bell"></i>
                </a>
            </li>

            {{-- User Menu --}}
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="far fa-user-circle mr-1"></i>
                    {{ auth()->user()->name }}
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-user mr-2"></i> Profile
                    </a>
                    <div class="dropdown-divider"></div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </button>
                    </form>
                </div>
            </li>
        </ul>
    </nav>

    {{-- Sidebar --}}
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="#" class="brand-link">
            <i class="fas fa-building brand-image ml-3"></i>
            <span class="brand-text font-weight-light">AMS</span>
        </a>
        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                    {{-- Load sidebar based on role --}}
                    @if(auth()->user()->hasRole('super-admin'))
                        @include('partials.super-admin-sidebar')
                    @elseif(auth()->user()->hasRole('admin'))
                        @include('partials.admin-sidebar')
                    @elseif(auth()->user()->hasRole('owner'))
                        @include('partials.owner-sidebar')
                    @elseif(auth()->user()->hasRole('employee'))
                        @include('partials.employee-sidebar')
                    @elseif(auth()->user()->hasRole('tenant'))
                        @include('partials.tenant-sidebar')
                    @endif
                </ul>
            </nav>
        </div>
    </aside>

    {{-- Content --}}
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">@yield('page-title')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            @yield('breadcrumb')
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <footer class="main-footer">
        <strong>Apartment Management System</strong>
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 1.0.0
        </div>
    </footer>

</div>
<!-- jQuery -->
<script src="{{ asset('jquery/jquery.min.js') }}"></script>
<!-- Bootstrap JS -->
<script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE JS -->
<script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>

<!-- Theme Toggle Script -->
<script>
const body     = document.body;
const icon     = document.getElementById('theme-icon');
const themeKey = 'ams_theme';

// Load saved theme
const savedTheme = localStorage.getItem(themeKey) || 'dark';
applyTheme(savedTheme);

document.getElementById('theme-toggle').addEventListener('click', function(e) {
    e.preventDefault();
    const current = localStorage.getItem(themeKey) || 'dark';
    const next    = current === 'dark' ? 'light' : 'dark';
    localStorage.setItem(themeKey, next);
    applyTheme(next);
});

function applyTheme(theme) {
    body.classList.remove('dark-theme', 'light-theme');
    body.classList.add(theme + '-theme');
    if (theme === 'light') {
        icon.className   = 'fas fa-moon';
        icon.title       = 'Switch to Dark Mode';
    } else {
        icon.className   = 'fas fa-sun';
        icon.title       = 'Switch to Light Mode';
    }
}
</script>

<!-- Toast Notification -->
@if(session('success') || session('error') || session('warning'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const type    = "{{ session('success') ? 'success' : (session('warning') ? 'warning' : 'error') }}";
        const message = "{{ session('success') ?? session('warning') ?? session('error') }}";
        const colors  = { success: '#28a745', warning: '#dc3545', error: '#dc3545' };
        const icons   = { success: '✔', warning: '🗑', error: '✖' };

        const toast = document.createElement('div');
        toast.innerHTML = `<span style="margin-right:8px">${icons[type]}</span>${message}`;
        toast.style.cssText = `
            position:fixed; top:20px; right:20px; z-index:9999;
            background:${colors[type]}; color:#fff;
            padding:12px 20px; border-radius:6px;
            box-shadow:0 4px 12px rgba(0,0,0,0.15);
            font-size:14px; display:flex; align-items:center;
            animation: slideIn .3s ease;
        `;

        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideIn { from { opacity:0; transform:translateX(50px); } to { opacity:1; transform:translateX(0); } }
            @keyframes slideOut { from { opacity:1; transform:translateX(0); } to { opacity:0; transform:translateX(50px); } }
        `;
        document.head.appendChild(style);
        document.body.appendChild(toast);

        setTimeout(() => {
            toast.style.animation = 'slideOut .3s ease forwards';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    });
</script>
@endif
</body>
</html>