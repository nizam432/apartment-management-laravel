@extends('layouts.app')

@section('title', 'Move Out Tenant')
@section('page-title', 'Move Out Tenant')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.tenants.index') }}">Tenants</a></li>
    <li class="breadcrumb-item active">Move Out</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header bg-danger">
                <h3 class="card-title text-white">
                    <i class="fas fa-sign-out-alt mr-2"></i>Move Out — {{ $tenant->name }}
                </h3>
            </div>
            <div class="card-body">

                {{-- Tenant Info --}}
                <div class="alert alert-warning">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td><b>Name</b></td>
                            <td>{{ $tenant->name }}</td>
                        </tr>
                        <tr>
                            <td><b>Building</b></td>
                            <td>{{ $tenant->building->name }}</td>
                        </tr>
                        <tr>
                            <td><b>Flat</b></td>
                            <td>{{ $tenant->flat->flat_number }}</td>
                        </tr>
                        <tr>
                            <td><b>Move In Date</b></td>
                            <td>{{ $tenant->move_in_date->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <td><b>Advance Paid</b></td>
                            <td><strong class="text-success">&#2547;{{ number_format($tenant->advance_amount) }}</strong></td>
                        </tr>
                    </table>
                </div>

                <form action="{{ route('admin.tenants.move-out.store', $tenant->id) }}" method="POST">
                    @csrf @method('PATCH')

                    {{-- Move Out Date --}}
                    <div class="form-group">
                        <label>Move Out Date <span class="text-danger">*</span></label>
                        <input type="date" name="move_out_date"
                            class="form-control @error('move_out_date') is-invalid @enderror"
                            value="{{ old('move_out_date', now()->format('Y-m-d')) }}">
                        @error('move_out_date')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Advance Paid (readonly) --}}
                    <div class="form-group">
                        <label>Advance Paid (BDT)</label>
                        <input type="text"
                            class="form-control bg-light"
                            value="{{ number_format($tenant->advance_amount) }}"
                            readonly>
                    </div>

                    {{-- Amount Returned --}}
                    <div class="form-group">
                        <label>Amount Returned to Tenant (BDT) <span class="text-danger">*</span></label>
                        <input type="number" name="amount_returned" id="amount_returned"
                            class="form-control @error('amount_returned') is-invalid @enderror"
                            value="{{ old('amount_returned', $tenant->advance_amount) }}"
                            min="0" max="{{ $tenant->advance_amount }}"
                            step="0.01"
                            placeholder="Amount returned to tenant">
                        @error('amount_returned')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Deduction (auto calculated, readonly) --}}
                    <div class="form-group">
                        <label>Deduction (BDT) <small class="text-muted">(Auto calculated)</small></label>
                        <input type="text" id="deduction_display"
                            class="form-control bg-light text-danger font-weight-bold"
                            value="0.00"
                            readonly>
                    </div>

                    {{-- Deduction Reason --}}
                    <div class="form-group">
                        <label>Deduction Reason <small class="text-muted">(Optional)</small></label>
                        <textarea name="deduction_reason" rows="2"
                            class="form-control @error('deduction_reason') is-invalid @enderror"
                            placeholder="e.g. Wall damage, broken door, unpaid dues">{{ old('deduction_reason') }}</textarea>
                        @error('deduction_reason')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Reason for leaving --}}
                    <div class="form-group">
                        <label>Reason for Leaving <small class="text-muted">(Optional)</small></label>
                        <input type="text" name="reason"
                            class="form-control @error('reason') is-invalid @enderror"
                            value="{{ old('reason') }}"
                            placeholder="e.g. Own house, Job transfer, Family reason">
                        @error('reason')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        This will mark the tenant as <b>Inactive</b> and the flat as <b>Vacant</b>.
                        A <b>Move Out Receipt</b> will be generated automatically.
                    </div>

                    <div class="mt-2">
                        <button type="submit" class="btn btn-danger"
                            onclick="return confirm('Are you sure you want to move out this tenant?')">
                            <i class="fas fa-sign-out-alt mr-1"></i> Confirm Move Out
                        </button>
                        <a href="{{ route('admin.tenants.index') }}" class="btn btn-secondary ml-2">
                            <i class="fas fa-times mr-1"></i> Cancel
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

{{-- Inline script — @push এর উপর নির্ভর নেই --}}
<script>
    var advancePaid = {{ $tenant->advance_amount ?? 0 }};

    function calcDeduction() {
        var returned  = parseFloat(document.getElementById('amount_returned').value) || 0;
        var deduction = advancePaid - returned;
        if (deduction < 0) deduction = 0;
        document.getElementById('deduction_display').value = deduction.toFixed(2);
    }

    document.getElementById('amount_returned').addEventListener('input', calcDeduction);

    // Page load এ run করো
    calcDeduction();
</script>
@endsection