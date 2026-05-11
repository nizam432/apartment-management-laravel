@extends('layouts.app')

@section('title', 'Super Admin Dashboard')
@section('page-title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')

    {{-- Stats Cards --}}
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1">
                    <i class="fas fa-users-cog"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Admins</span>
                    <span class="info-box-number">{{ $stats['total_admins'] }}</span>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-success elevation-1">
                    <i class="fas fa-user-check"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Active Admins</span>
                    <span class="info-box-number">{{ $stats['active_admins'] }}</span>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-warning elevation-1">
                    <i class="fas fa-building"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Buildings</span>
                    <span class="info-box-number">{{ $stats['total_buildings'] }}</span>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-danger elevation-1">
                    <i class="fas fa-users"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Tenants</span>
                    <span class="info-box-number">{{ $stats['total_tenants'] }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Latest Admins --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Latest Admins</h3>
                    <div class="card-tools">
                        <a href="{{ route('super-admin.admins.index') }}" class="btn btn-primary btn-sm">
                            View All
                        </a>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Joined</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestAdmins as $admin)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $admin->name }}</td>
                                <td>{{ $admin->phone }}</td>
                                <td>{{ $admin->email ?? '—' }}</td>
                                <td>
                                    @if($admin->is_active)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>{{ $admin->created_at->format('d M Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">No admins found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection