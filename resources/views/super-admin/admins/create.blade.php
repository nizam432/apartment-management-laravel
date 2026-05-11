@extends('layouts.app')

@section('title', 'Add Admin')
@section('page-title', 'Add New Admin')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('super-admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('super-admin.admins.index') }}">Admins</a></li>
    <li class="breadcrumb-item active">Add Admin</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Add New Admin</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('super-admin.admins.store') }}" method="POST">
            @csrf
            <div class="row">
                {{-- Name --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}" placeholder="Enter full name">
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
                            value="{{ old('phone') }}" placeholder="01XXXXXXXXX">
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
                            value="{{ old('email') }}" placeholder="example@email.com">
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
                            value="{{ old('username') }}" placeholder="Enter username">
                        @error('username')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- Password --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Password <span class="text-danger">*</span></label>
                        <input type="password" name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Minimum 6 characters">
                        @error('password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- Confirm Password --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Confirm Password <span class="text-danger">*</span></label>
                        <input type="password" name="password_confirmation"
                            class="form-control"
                            placeholder="Repeat password">
                    </div>
                </div>
            </div>

            <div class="mt-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-1"></i> Save Admin
                </button>
                <a href="{{ route('super-admin.admins.index') }}" class="btn btn-secondary ml-2">
                    <i class="fas fa-times mr-1"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection