@extends('layouts.app')

@section('title', 'Utility Bill Details')
@section('page-title', 'Utility Bill Details')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.utility-bills.index') }}">Utility Bills</a></li>
    <li class="breadcrumb-item active">Details</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-file-invoice-dollar mr-2"></i>
                    Utility Bill — {{ \Carbon\Carbon::parse($utilityBill->month . '-01')->format('F Y') }}
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><b>Tenant</b></td>
                                <td>{{ $utilityBill->tenant->name }}</td>
                            </tr>
                            <tr>
                                <td><b>Phone</b></td>
                                <td>{{ $utilityBill->tenant->phone }}</td>
                            </tr>
                            <tr>
                                <td><b>Building</b></td>
                                <td>{{ $utilityBill->building->name }}</td>
                            </tr>
                            <tr>
                                <td><b>Flat</b></td>
                                <td>{{ $utilityBill->flat->flat_number }}</td>
                            </tr>
                            <tr>
                                <td><b>Month</b></td>
                                <td>{{ \Carbon\Carbon::parse($utilityBill->month . '-01')->format('F Y') }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><b>Water Bill</b></td>
                                <td>৳{{ number_format($utilityBill->water_bill) }}</td>
                            </tr>
                            <tr>
                                <td><b>Electricity Bill</b></td>
                                <td>
                                    ৳{{ number_format($utilityBill->electricity_bill) }}
                                    @if($utilityBill->unit_used)
                                        <small class="text-muted">({{ $utilityBill->unit_used }} units × ৳{{ $utilityBill->rate_per_unit }})</small>
                                    @endif
                                </td>
                            </tr>
                            @if($utilityBill->other_bill > 0)
                            <tr>
                                <td><b>{{ $utilityBill->other_bill_title ?? 'Other' }}</b></td>
                                <td>৳{{ number_format($utilityBill->other_bill) }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td><b>Total</b></td>
                                <td><b class="text-primary">৳{{ number_format($utilityBill->total_amount) }}</b></td>
                            </tr>
                            <tr>
                                <td><b>Status</b></td>
                                <td>
                                    <span class="badge {{ $utilityBill->status === 'paid' ? 'badge-success' : 'badge-danger' }}">
                                        {{ ucfirst($utilityBill->status) }}
                                    </span>
                                </td>
                            </tr>
                            @if($utilityBill->status === 'paid')
                            <tr>
                                <td><b>Paid Date</b></td>
                                <td>{{ $utilityBill->paid_date->format('d M Y') }}</td>
                            </tr>
                            <tr>
                                <td><b>Method</b></td>
                                <td><span class="badge badge-info">{{ ucfirst($utilityBill->payment_method) }}</span></td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>

                {{-- Mark as Paid --}}
                @if($utilityBill->status === 'unpaid')
                <hr>
                <h5>Mark as Paid</h5>
                <form action="{{ route('admin.utility-bills.mark-paid', $utilityBill->id) }}" method="POST">
                    @csrf @method('PATCH')
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Paid Date <span class="text-danger">*</span></label>
                                <input type="date" name="paid_date" class="form-control"
                                    value="{{ now()->format('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Payment Method <span class="text-danger">*</span></label>
                                <select name="payment_method" class="form-control">
                                    <option value="cash">Cash</option>
                                    <option value="bkash">bKash</option>
                                    <option value="nagad">Nagad</option>
                                    <option value="bank">Bank</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-success btn-block">
                                <i class="fas fa-check mr-1"></i> Mark as Paid
                            </button>
                        </div>
                    </div>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection