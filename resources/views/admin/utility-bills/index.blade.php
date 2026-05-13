@extends('layouts.app')

@section('title', 'Utility Bills')
@section('page-title', 'Utility Bill Management')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Utility Bills</li>
@endsection

@section('content')

{{-- Filter --}}
<div class="card">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.utility-bills.index') }}">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group mb-0">
                        <label>Filter by Month</label>
                        <input type="month" name="month" class="form-control"
                            value="{{ request('month') }}">
                    </div>
                </div>
                <div class="col-md-3">
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
                <div class="col-md-3">
                    <div class="form-group mb-0">
                        <label>Filter by Status</label>
                        <select name="status" class="form-control">
                            <option value="">All</option>
                            <option value="unpaid" {{ request('status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                            <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary mr-2">
                        <i class="fas fa-filter mr-1"></i> Filter
                    </button>
                    <a href="{{ route('admin.utility-bills.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times mr-1"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">All Utility Bills</h3>
        <div class="card-tools">
            <a href="{{ route('admin.utility-bills.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus mr-1"></i> Add Bill
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
                    <th>Water</th>
                    <th>Electricity</th>
                    <th>Other</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bills as $bill)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $bill->tenant->name }}</td>
                    <td>{{ $bill->building->name }}</td>
                    <td>{{ $bill->flat->flat_number }}</td>
                    <td>{{ \Carbon\Carbon::parse($bill->month . '-01')->format('M Y') }}</td>
                    <td>৳{{ number_format($bill->water_bill) }}</td>
                    <td>৳{{ number_format($bill->electricity_bill) }}</td>
                    <td>
                        @if($bill->other_bill > 0)
                            ৳{{ number_format($bill->other_bill) }}
                            <small class="text-muted">({{ $bill->other_bill_title }})</small>
                        @else
                            —
                        @endif
                    </td>
                    <td><b>৳{{ number_format($bill->total_amount) }}</b></td>
                    <td>
                        @if($bill->status === 'paid')
                            <span class="badge badge-success">Paid</span>
                        @else
                            <span class="badge badge-danger">Unpaid</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.utility-bills.show', $bill->id) }}"
                           class="btn btn-sm btn-secondary">
                            <i class="fas fa-eye"></i>
                        </a>
                        <form action="{{ route('admin.utility-bills.destroy', $bill->id) }}"
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
                    <td colspan="11" class="text-center">No utility bills found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $bills->links() }}
    </div>
</div>
@endsection