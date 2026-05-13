@extends('layouts.app')

@section('title', 'Payment Details')
@section('page-title', 'Payment Details')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.rent-payments.index') }}">Rent Payments</a></li>
    <li class="breadcrumb-item active">Details</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-receipt mr-2"></i>
                    Payment Receipt — {{ \Carbon\Carbon::parse($rentPayment->month . '-01')->format('F Y') }}
                </h3>
                <div class="card-tools">
                    <a href="{{ route('admin.rent-payments.tenant-history', $rentPayment->tenant_id) }}"
                       class="btn btn-sm btn-secondary">
                        <i class="fas fa-history mr-1"></i> Payment History
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><b>Tenant</b></td>
                                <td>{{ $rentPayment->tenant->name }}</td>
                            </tr>
                            <tr>
                                <td><b>Phone</b></td>
                                <td>{{ $rentPayment->tenant->phone }}</td>
                            </tr>
                            <tr>
                                <td><b>Building</b></td>
                                <td>{{ $rentPayment->building->name }}</td>
                            </tr>
                            <tr>
                                <td><b>Flat</b></td>
                                <td>{{ $rentPayment->flat->flat_number }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><b>Month</b></td>
                                <td>{{ \Carbon\Carbon::parse($rentPayment->month . '-01')->format('F Y') }}</td>
                            </tr>
                            <tr>
                                <td><b>Rent Amount</b></td>
                                <td>৳{{ number_format($rentPayment->rent_amount) }}</td>
                            </tr>
                            <tr>
                                <td><b>Paid Amount</b></td>
                                <td class="text-success"><b>৳{{ number_format($rentPayment->paid_amount) }}</b></td>
                            </tr>
                            <tr>
                                <td><b>Due Amount</b></td>
                                <td class="{{ $rentPayment->due_amount > 0 ? 'text-danger' : 'text-success' }}">
                                    <b>৳{{ number_format($rentPayment->due_amount) }}</b>
                                </td>
                            </tr>
                            <tr>
                                <td><b>Method</b></td>
                                <td><span class="badge badge-info">{{ ucfirst($rentPayment->payment_method) }}</span></td>
                            </tr>
                            <tr>
                                <td><b>Transaction ID</b></td>
                                <td>{{ $rentPayment->transaction_id ?? '—' }}</td>
                            </tr>
                            <tr>
                                <td><b>Paid Date</b></td>
                                <td>{{ $rentPayment->paid_date->format('d M Y') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                @if($rentPayment->note)
                <div class="alert alert-info mt-2">
                    <b>Note:</b> {{ $rentPayment->note }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection