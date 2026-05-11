@extends('layouts.app')

@section('title', 'Admin Dashboard')
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
                <span class="info-box-icon bg-success elevation-1">
                    <i class="fas fa-users"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Tenants</span>
                    <span class="info-box-number">{{ $stats['total_tenants'] }}</span>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-warning elevation-1">
                    <i class="fas fa-user-check"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Active Tenants</span>
                    <span class="info-box-number">{{ $stats['active_tenants'] }}</span>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-danger elevation-1">
                    <i class="fas fa-door-open"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Vacant Flats</span>
                    <span class="info-box-number">{{ $stats['vacant_flats'] }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Latest Tenants --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Latest Tenants</h3>
                    <div class="card-tools">
                        <a href="#" class="btn btn-primary btn-sm">View All</a>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Building</th>
                                <th>Rent</th>
                                <th>Move In</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestTenants as $tenant)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $tenant->name }}</td>
                                <td>{{ $tenant->phone }}</td>
                                <td>{{ $tenant->building->name ?? '—' }}</td>
                                <td>৳{{ number_format($tenant->monthly_rent) }}</td>
                                <td>{{ $tenant->move_in_date->format('d M Y') }}</td>
                                <td>
                                    <span class="badge {{ $tenant->status === 'active' ? 'badge-success' : 'badge-danger' }}">
                                        {{ ucfirst($tenant->status) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">No tenants found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection