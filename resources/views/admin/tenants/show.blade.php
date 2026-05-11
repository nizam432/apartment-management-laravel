@extends('layouts.app')

@section('title', 'Tenant Details')
@section('page-title', 'Tenant Details')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.tenants.index') }}">Tenants</a></li>
    <li class="breadcrumb-item active">{{ $tenant->name }}</li>
@endsection

@section('content')
<div class="row">
    {{-- Profile Card --}}
    <div class="col-md-4">
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    @if($tenant->picture)
                        <img src="{{ asset('storage/' . $tenant->picture) }}"
                             alt="{{ $tenant->name }}"
                             class="profile-user-img img-fluid img-circle" style="width:100px;height:100px;object-fit:cover;">
                    @else
                        <i class="fas fa-user-circle fa-5x text-muted"></i>
                    @endif
                </div>
                <h3 class="profile-username text-center mt-2">{{ $tenant->name }}</h3>
                <p class="text-muted text-center">{{ $tenant->profession ?? 'N/A' }}</p>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Phone</b> <span class="float-right">{{ $tenant->phone }}</span>
                    </li>
                    <li class="list-group-item">
                        <b>Email</b> <span class="float-right">{{ $tenant->email ?? '—' }}</span>
                    </li>
                    <li class="list-group-item">
                        <b>Gender</b> <span class="float-right">{{ ucfirst($tenant->gender ?? '—') }}</span>
                    </li>
                    <li class="list-group-item">
                        <b>Date of Birth</b>
                        <span class="float-right">{{ $tenant->date_of_birth?->format('d M Y') ?? '—' }}</span>
                    </li>
                    <li class="list-group-item">
                        <b>Status</b>
                        <span class="float-right">
                            <span class="badge {{ $tenant->status === 'active' ? 'badge-success' : 'badge-danger' }}">
                                {{ ucfirst($tenant->status) }}
                            </span>
                        </span>
                    </li>
                </ul>

                <a href="{{ route('admin.tenants.edit', $tenant->id) }}" class="btn btn-info btn-block">
                    <i class="fas fa-edit mr-1"></i> Edit Tenant
                </a>
            </div>
        </div>

        {{-- NID Card --}}
        @if($tenant->nid_front || $tenant->nid_back)
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">NID Documents</h3>
            </div>
            <div class="card-body">
                @if($tenant->nid_front)
                    <p><b>NID Front:</b></p>
                    <img src="{{ asset('storage/' . $tenant->nid_front) }}"
                         alt="NID Front" class="img-fluid rounded mb-2">
                @endif
                @if($tenant->nid_back)
                    <p><b>NID Back:</b></p>
                    <img src="{{ asset('storage/' . $tenant->nid_back) }}"
                         alt="NID Back" class="img-fluid rounded">
                @endif
            </div>
        </div>
        @endif
    </div>

    {{-- Details --}}
    <div class="col-md-8">
        {{-- Flat Info --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-home mr-2"></i>Flat & Rent Information</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><b>Building</b></td>
                                <td>{{ $tenant->building->name ?? '—' }}</td>
                            </tr>
                            <tr>
                                <td><b>Floor</b></td>
                                <td>{{ $tenant->floor->floor_name ?? '—' }}</td>
                            </tr>
                            <tr>
                                <td><b>Flat</b></td>
                                <td>{{ $tenant->flat->flat_number ?? '—' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><b>Monthly Rent</b></td>
                                <td>৳{{ number_format($tenant->monthly_rent) }}</td>
                            </tr>
                            <tr>
                                <td><b>Advance</b></td>
                                <td>৳{{ number_format($tenant->advance_amount) }}</td>
                            </tr>
                            <tr>
                                <td><b>Move In</b></td>
                                <td>{{ $tenant->move_in_date->format('d M Y') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Emergency Contact --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-phone mr-2"></i>Emergency Contact</h3>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td><b>Name</b></td>
                        <td>{{ $tenant->emergency_contact_name ?? '—' }}</td>
                    </tr>
                    <tr>
                        <td><b>Phone</b></td>
                        <td>{{ $tenant->emergency_contact_phone ?? '—' }}</td>
                    </tr>
                    <tr>
                        <td><b>Address</b></td>
                        <td>{{ $tenant->permanent_address ?? '—' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        {{-- Notes --}}
        @if($tenant->notes)
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-sticky-note mr-2"></i>Notes</h3>
            </div>
            <div class="card-body">
                {{ $tenant->notes }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection