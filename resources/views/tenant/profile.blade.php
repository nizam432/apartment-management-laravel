@extends('layouts.app')

@section('title', 'Profile')
@section('page-title', 'My Profile')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('tenant.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Profile</li>
@endsection

@section('content')
<div class="row">
    {{-- Profile Info --}}
    <div class="col-md-4">
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    @if($tenant && $tenant->picture)
                        <img src="{{ asset('storage/' . $tenant->picture) }}"
                             class="profile-user-img img-fluid img-circle"
                             style="width:100px;height:100px;object-fit:cover;">
                    @else
                        <i class="fas fa-user-circle fa-5x text-muted"></i>
                    @endif
                </div>
                <h3 class="profile-username text-center mt-2">{{ $user->name }}</h3>
                <p class="text-muted text-center">Tenant</p>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Phone</b> <span class="float-right">{{ $user->phone }}</span>
                    </li>
                    <li class="list-group-item">
                        <b>Email</b> <span class="float-right">{{ $user->email ?? '—' }}</span>
                    </li>
                    @if($tenant)
                    <li class="list-group-item">
                        <b>Profession</b> <span class="float-right">{{ $tenant->profession ?? '—' }}</span>
                    </li>
                    <li class="list-group-item">
                        <b>Move In</b>
                        <span class="float-right">{{ $tenant->move_in_date?->format('d M Y') ?? '—' }}</span>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>

    {{-- Update Profile --}}
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Update Profile</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('tenant.profile.update') }}" method="POST">
                    @csrf @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $user->name) }}">
                                @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Phone <span class="text-danger">*</span></label>
                                <input type="text" name="phone"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    value="{{ old('phone', $user->phone) }}">
                                @error('phone') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email <small class="text-muted">(Optional)</small></label>
                                <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', $user->email) }}">
                                @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>New Password <small class="text-muted">(Leave blank to keep current)</small></label>
                                <input type="password" name="password" autocomplete="new-password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Minimum 6 characters">
                                @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Confirm New Password</label>
                                <input type="password" name="password_confirmation"
                                    class="form-control" placeholder="Repeat new password">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Update Profile
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection