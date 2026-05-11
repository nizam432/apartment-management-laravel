@extends('layouts.app')

@section('title', 'Edit Admin')
@section('page-title', 'Edit Admin')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('super-admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('super-admin.admins.index') }}">Admins</a></li>
    <li class="breadcrumb-item active">Edit Admin</li>
@endsection

@section('sidebar')
    <li class="nav-item">
        <a href="{{ route('super-admin.dashboard') }}" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
        </a>
    </li>
    <li class="nav-item menu-open">
        <a href="#" class="nav-link active">
            <i class="nav-icon fas fa-users-cog"></i>
            <p>Admin Management <i class="right fas fa-angle-left"></i></p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('super-admin.admins.index') }}" class="nav-link active">
                    <i class="far fa-circle nav-icon"></i>
                    <p>All Admins</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('super-admin.admins.create') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Add Admin</p>
                </a>
            </li>
        </ul>
    </li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit Admin — {{ $admin->name }}</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('super-admin.admins.update', $admin->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="row">
                {{-- Name --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $admin->name) }}" placeholder="Enter full name">
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- Phone --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Phone <span class="text-danger">*</span></label>
                        <input type="text" name="phone"
                            class="form-control @error('phone') is-invalid @enderror"
                            value="{{ old('phone', $admin->phone) }}" placeholder="01XXXXXXXXX">
                        @error('phone')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- Email --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Email <small class="text-muted">(Optional)</small></label>
                        <input type="email" name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email', $admin->email) }}" placeholder="example@email.com">
                        @error('email')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- Username --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Username <small class="text-muted">(Optional)</small></label>
                        <input type="text" name="username"
                            class="form-control @error('username') is-invalid @enderror"
                            value="{{ old('username', $admin->username) }}" placeholder="Enter username">
                        @error('username')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- Password --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label>New Password <small class="text-muted">(Leave blank to keep current)</small></label>
                        <input type="password" name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Minimum 6 characters"
                            autocomplete="new-password">
                        @error('password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- Confirm Password --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Confirm New Password</label>
                        <input type="password" name="password_confirmation"
                            class="form-control"
                            placeholder="Repeat new password">
                    </div>
                </div>
            </div>

            <div class="mt-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-1"></i> Update Admin
                </button>
                <a href="{{ route('super-admin.admins.index') }}" class="btn btn-secondary ml-2">
                    <i class="fas fa-times mr-1"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection