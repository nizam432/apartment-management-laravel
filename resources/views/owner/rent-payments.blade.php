@extends('layouts.app')

@section('title', 'Rent Payments')
@section('page-title', 'Rent Payment History')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('owner.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Rent Payments</li>
@endsection

@section('content')

{{-- Summary --}}
<div class="row">
    <div class="col-md-6">
        <div class="info-box">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-money-bill-wave"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Received</span>
                <span class="info-box-number">৳{{ number_format($totalReceived) }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="info-box">
            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-exclamation-circle"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Due</span>
                <span class="info-box-number">৳{{ number_format($totalDue) }}</span>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">All Rent Payments</h3>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tenant</th>
                    <th>Building</th>
                    <th>Flat</th>
                    <th>Month</th>
                    <th>Rent</th>
                    <th>Paid</th>
                    <th>Due</th>
                    <th>Method</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $payment->tenant->name }}</td>
                    <td>{{ $payment->building->name }}</td>
                    <td>{{ $payment->flat->flat_number }}</td>
                    <td>{{ \Carbon\Carbon::parse($payment->month . '-01')->format('M Y') }}</td>
                    <td>৳{{ number_format($payment->rent_amount) }}</td>
                    <td class="text-success">৳{{ number_format($payment->paid_amount) }}</td>
                    <td class="{{ $payment->due_amount > 0 ? 'text-danger' : 'text-success' }}">
                        ৳{{ number_format($payment->due_amount) }}
                    </td>
                    <td><span class="badge badge-info">{{ ucfirst($payment->payment_method) }}</span></td>
                    <td>{{ $payment->paid_date->format('d M Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center">No payments found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $payments->links() }}
    </div>
</div>
@endsection