@extends('layouts.app')

@section('title', 'Owner Dashboard')
@section('page-title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')

{{-- Stats --}}
<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-door-open"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Flats</span>
                <span class="info-box-number">{{ $stats['total_flats'] }}</span>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-users"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Active Tenants</span>
                <span class="info-box-number">{{ $stats['total_tenants'] }}</span>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-money-bill-wave"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Received</span>
                <span class="info-box-number">৳{{ number_format($stats['total_received']) }}</span>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-exclamation-circle"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Due</span>
                <span class="info-box-number">৳{{ number_format($stats['total_due']) }}</span>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-check-circle"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Occupied Flats</span>
                <span class="info-box-number">{{ $stats['occupied_flats'] }}</span>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-door-open"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Vacant Flats</span>
                <span class="info-box-number">{{ $stats['vacant_flats'] }}</span>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-exclamation-triangle"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Pending Complaints</span>
                <span class="info-box-number">{{ $stats['pending_complaints'] }}</span>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-file-invoice-dollar"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Unpaid Bills</span>
                <span class="info-box-number">{{ $stats['unpaid_bills'] }}</span>
            </div>
        </div>
    </div>
</div>

{{-- Latest Payments --}}
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Latest Rent Payments</h3>
        <div class="card-tools">
            <a href="{{ route('owner.rent-payments') }}" class="btn btn-primary btn-sm">View All</a>
        </div>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tenant</th>
                    <th>Flat</th>
                    <th>Month</th>
                    <th>Paid</th>
                    <th>Due</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($latestPayments as $payment)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $payment->tenant->name }}</td>
                    <td>{{ $payment->flat->flat_number }}</td>
                    <td>{{ \Carbon\Carbon::parse($payment->month . '-01')->format('M Y') }}</td>
                    <td class="text-success">৳{{ number_format($payment->paid_amount) }}</td>
                    <td class="{{ $payment->due_amount > 0 ? 'text-danger' : 'text-success' }}">
                        ৳{{ number_format($payment->due_amount) }}
                    </td>
                    <td>{{ $payment->paid_date->format('d M Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">No payments found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection