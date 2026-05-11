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
        .nav-sidebar .nav-link p { font-size: 14px; }
        .table td, .table th { font-size: 14px; }
        .card-title { font-size: 16px; }
        .btn { font-size: 13px; }
        .badge { font-size: 12px; }
        .breadcrumb-item { font-size: 13px; }
        .main-header .navbar-nav .nav-link { font-size: 14px; }
        h1.m-0 { font-size: 22px; }
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
            {{-- Notifications --}}
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="far fa-bell"></i>
                </a>
            </li>

            {{-- User Menu --}}
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-user-circle"></i>
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