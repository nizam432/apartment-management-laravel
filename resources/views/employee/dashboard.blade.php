@extends('layouts.app')

@section('title', 'Employee Dashboard')
@section('page-title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')

{{-- Employee Info --}}
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-info">
            <i class="fas fa-user-hard-hat mr-2"></i>
            Welcome, <b>{{ $employee->name }}</b> |
            {{ $employee->designation }} |
            {{ $employee->building->name ?? '' }} |
            <span class="badge badge-success">{{ ucfirst($employee->employment_status) }}</span>
        </div>
    </div>
</div>

{{-- Stats --}}
<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-user-check"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Today's Visitors</span>
                <span class="info-box-number">{{ $stats['today_visitors'] }}</span>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-clipboard-list"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Visitors</span>
                <span class="info-box-number">{{ $stats['total_visitors'] }}</span>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-sign-out-alt"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Pending Checkout</span>
                <span class="info-box-number">{{ $stats['pending_checkout'] }}</span>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-bullhorn"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Notices</span>
                <span class="info-box-number">{{ $stats['total_notices'] }}</span>
            </div>
        </div>
    </div>
</div>

{{-- Recent Visitors --}}
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Recent Visitors</h3>
        <div class="card-tools">
            <a href="{{ route('employee.visitor-logs.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus mr-1"></i> Add Visitor
            </a>
        </div>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Visitor Name</th>
                    <th>Flat</th>
                    <th>Tenant</th>
                    <th>In Time</th>
                    <th>Out Time</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentVisitors as $log)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $log->visitor_name }}</td>
                    <td>{{ $log->flat->flat_number ?? '—' }}</td>
                    <td>{{ $log->tenant->name ?? '—' }}</td>
                    <td>{{ $log->in_time->format('d M Y h:i A') }}</td>
                    <td>{{ $log->out_time ? $log->out_time->format('d M Y h:i A') : '<span class="badge badge-warning">Pending</span>' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">No visitors today.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection