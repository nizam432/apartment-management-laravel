@extends('layouts.app')

@section('title', 'Tenant Dashboard')
@section('page-title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')

{{-- Tenant Info --}}
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-info">
            <i class="fas fa-home mr-2"></i>
            <b>{{ $tenant->name }}</b> |
            {{ $tenant->building->name ?? '' }} |
            Flat: <b>{{ $tenant->flat->flat_number ?? '' }}</b> |
            Floor: {{ $tenant->floor->floor_name ?? '' }} |
            Rent: <b>৳{{ number_format($tenant->monthly_rent) }}</b>/month
        </div>
    </div>
</div>

{{-- Stats --}}
<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-money-bill-wave"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Paid</span>
                <span class="info-box-number">৳{{ number_format($stats['total_paid']) }}</span>
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
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-file-invoice-dollar"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Unpaid Bills</span>
                <span class="info-box-number">{{ $stats['unpaid_bills'] }}</span>
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
</div>

<div class="row">
    {{-- Latest Payments --}}
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Latest Rent Payments</h3>
                <div class="card-tools">
                    <a href="{{ route('tenant.rent-payments') }}" class="btn btn-primary btn-sm">View All</a>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Month</th>
                            <th>Paid</th>
                            <th>Due</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($latestPayments as $payment)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($payment->month . '-01')->format('M Y') }}</td>
                            <td class="text-success">৳{{ number_format($payment->paid_amount) }}</td>
                            <td class="{{ $payment->due_amount > 0 ? 'text-danger' : 'text-success' }}">
                                ৳{{ number_format($payment->due_amount) }}
                            </td>
                            <td>{{ $payment->paid_date->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">No payments found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Latest Notices --}}
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Latest Notices</h3>
                <div class="card-tools">
                    <a href="{{ route('tenant.notices') }}" class="btn btn-primary btn-sm">View All</a>
                </div>
            </div>
            <div class="card-body">
                @forelse($notices as $notice)
                <div class="mb-3">
                    <h6><b>{{ $notice->title }}</b></h6>
                    <p class="text-muted mb-1">{{ Str::limit($notice->body, 100) }}</p>
                    <small class="text-muted">{{ $notice->created_at->format('d M Y') }}</small>
                    <hr>
                </div>
                @empty
                <p class="text-center text-muted">No notices found.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection