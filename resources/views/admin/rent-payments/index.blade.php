@extends('layouts.app')

@section('title', 'Rent Payments')
@section('page-title', 'Rent Payment Management')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Rent Payments</li>
@endsection

@section('content')

{{-- Filter --}}
<div class="card">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.rent-payments.index') }}">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group mb-0">
                        <label>Filter by Month</label>
                        <input type="month" name="month" class="form-control"
                            value="{{ request('month') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-0">
                        <label>Filter by Building</label>
                        <select name="building_id" class="form-control">
                            <option value="">All Buildings</option>
                            @foreach($buildings as $building)
                                <option value="{{ $building->id }}" {{ request('building_id') == $building->id ? 'selected' : '' }}>
                                    {{ $building->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary mr-2">
                        <i class="fas fa-filter mr-1"></i> Filter
                    </button>
                    <a href="{{ route('admin.rent-payments.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times mr-1"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">All Payments</h3>
        <div class="card-tools">
            <a href="{{ route('admin.rent-payments.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus mr-1"></i> Collect Rent
            </a>
        </div>
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
                    <th>Paid Date</th>
                    <th>Action</th>
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
                    <td><span class="text-success">৳{{ number_format($payment->paid_amount) }}</span></td>
                    <td>
                        @if($payment->due_amount > 0)
                            <span class="text-danger">৳{{ number_format($payment->due_amount) }}</span>
                        @else
                            <span class="text-success">৳0</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge badge-info">{{ ucfirst($payment->payment_method) }}</span>
                    </td>
                    <td>{{ $payment->paid_date->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('admin.rent-payments.show', $payment->id) }}"
                           class="btn btn-sm btn-secondary">
                            <i class="fas fa-eye"></i>
                        </a>
                        <form action="{{ route('admin.rent-payments.destroy', $payment->id) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Are you sure?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="11" class="text-center">No payments found.</td>
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