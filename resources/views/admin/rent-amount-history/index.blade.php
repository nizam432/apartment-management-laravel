@extends('layouts.app')

@section('title', 'Update Rent Amount')
@section('page-title', 'Update Rent Amount')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.tenants.index') }}">Tenants</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.rent-amount-history.index', $tenant->id) }}">Rent History</a></li>
    <li class="breadcrumb-item active">Update Rent</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Update Rent Amount — {{ $tenant->name }}</h3>
            </div>
            <div class="card-body">
                <div class="alert alert-warning">
                    <i class="fas fa-info-circle mr-2"></i>
                    Current Rent: <b>৳{{ number_format($tenant->monthly_rent) }}</b>/month
                </div>

                <form action="{{ route('admin.rent-amount-history.store', $tenant->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>New Rent Amount (BDT) <span class="text-danger">*</span></label>
                        <input type="number" name="new_amount"
                            class="form-control @error('new_amount') is-invalid @enderror"
                            value="{{ old('new_amount') }}"
                            placeholder="Enter new rent amount">
                        @error('new_amount') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label>Effective From <span class="text-danger">*</span></label>
                        <input type="date" name="effective_from"
                            class="form-control @error('effective_from') is-invalid @enderror"
                            value="{{ old('effective_from') }}">
                        <small class="text-muted">New amount will apply from this date</small>
                        @error('effective_from') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label>Reason <small class="text-muted">(Optional)</small></label>
                        <input type="text" name="reason"
                            class="form-control @error('reason') is-invalid @enderror"
                            value="{{ old('reason') }}"
                            placeholder="e.g. Annual increment, Market rate adjustment">
                        @error('reason') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i> Update Rent
                        </button>
                        <a href="{{ route('admin.rent-amount-history.index', $tenant->id) }}"
                           class="btn btn-secondary ml-2">
                            <i class="fas fa-times mr-1"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection