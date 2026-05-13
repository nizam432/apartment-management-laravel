@extends('layouts.app')

@section('title', 'Collect Rent')
@section('page-title', 'Collect Rent')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.rent-payments.index') }}">Rent Payments</a></li>
    <li class="breadcrumb-item active">Collect Rent</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Collect Rent</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.rent-payments.store') }}" method="POST">
            @csrf
            <div class="row">
                {{-- Building --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Building <span class="text-danger">*</span></label>
                        <select name="building_id" id="building_id"
                            class="form-control @error('building_id') is-invalid @enderror"
                            onchange="loadFloors(this.value)">
                            <option value="">Select Building</option>
                            @foreach($buildings as $building)
                                <option value="{{ $building->id }}" {{ old('building_id') == $building->id ? 'selected' : '' }}>
                                    {{ $building->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('building_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Flat --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Flat <span class="text-danger">*</span></label>
                        <select name="flat_id" id="flat_id"
                            class="form-control @error('flat_id') is-invalid @enderror"
                            onchange="loadTenant(this.value)">
                            <option value="">Select Building First</option>
                        </select>
                        @error('flat_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Tenant --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Tenant <span class="text-danger">*</span></label>
                        <input type="text" id="tenant_name" class="form-control" readonly placeholder="Auto-filled">
                        <input type="hidden" name="tenant_id" id="tenant_id">
                        @error('tenant_id') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Month --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Month <span class="text-danger">*</span></label>
                        <input type="month" name="month"
                            class="form-control @error('month') is-invalid @enderror"
                            value="{{ old('month', now()->format('Y-m')) }}">
                        @error('month') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Rent Amount --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Rent Amount (BDT) <span class="text-danger">*</span></label>
                        <input type="number" name="rent_amount" id="rent_amount"
                            class="form-control @error('rent_amount') is-invalid @enderror"
                            value="{{ old('rent_amount') }}" placeholder="Auto-filled from flat">
                        @error('rent_amount') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Paid Amount --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Paid Amount (BDT) <span class="text-danger">*</span></label>
                        <input type="number" name="paid_amount" id="paid_amount"
                            class="form-control @error('paid_amount') is-invalid @enderror"
                            value="{{ old('paid_amount') }}" placeholder="Enter paid amount"
                            oninput="calcDue()">
                        @error('paid_amount') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Due Amount (readonly) --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Due Amount (BDT)</label>
                        <input type="number" id="due_display" class="form-control" readonly value="0">
                    </div>
                </div>

                {{-- Payment Method --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Payment Method <span class="text-danger">*</span></label>
                        <select name="payment_method"
                            class="form-control @error('payment_method') is-invalid @enderror">
                            <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="bkash" {{ old('payment_method') == 'bkash' ? 'selected' : '' }}>bKash</option>
                            <option value="nagad" {{ old('payment_method') == 'nagad' ? 'selected' : '' }}>Nagad</option>
                            <option value="bank" {{ old('payment_method') == 'bank' ? 'selected' : '' }}>Bank</option>
                            <option value="other" {{ old('payment_method') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('payment_method') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Paid Date --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Paid Date <span class="text-danger">*</span></label>
                        <input type="date" name="paid_date"
                            class="form-control @error('paid_date') is-invalid @enderror"
                            value="{{ old('paid_date', now()->format('Y-m-d')) }}">
                        @error('paid_date') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Transaction ID --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Transaction ID <small class="text-muted">(Optional)</small></label>
                        <input type="text" name="transaction_id"
                            class="form-control @error('transaction_id') is-invalid @enderror"
                            value="{{ old('transaction_id') }}" placeholder="bKash/Nagad/Bank TrxID">
                        @error('transaction_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Note --}}
                <div class="col-md-8">
                    <div class="form-group">
                        <label>Note <small class="text-muted">(Optional)</small></label>
                        <input type="text" name="note"
                            class="form-control @error('note') is-invalid @enderror"
                            value="{{ old('note') }}" placeholder="Any additional note">
                        @error('note') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="mt-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-1"></i> Save Payment
                </button>
                <a href="{{ route('admin.rent-payments.index') }}" class="btn btn-secondary ml-2">
                    <i class="fas fa-times mr-1"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function loadFloors(buildingId) {
    const flatSelect = document.getElementById('flat_id');
    flatSelect.innerHTML = '<option value="">Loading...</option>';
    clearTenant();

    if (!buildingId) { flatSelect.innerHTML = '<option value="">Select Building First</option>'; return; }

    fetch(`/admin/floors/by-building/${buildingId}`)
        .then(r => r.json())
        .then(floors => {
            flatSelect.innerHTML = '<option value="">Select Flat</option>';
            floors.forEach(floor => {
                fetch(`/admin/tenants/flats-by-floor/${floor.id}`)
                    .then(r => r.json())
                    .then(flats => {
                        flats.forEach(flat => {
                            flatSelect.innerHTML += `<option value="${flat.id}">${flat.flat_number} — ৳${flat.rent_amount}</option>`;
                        });
                    });
            });
        });
}

function loadTenant(flatId) {
    clearTenant();
    if (!flatId) return;

    fetch(`/admin/rent-payments/tenant-by-flat/${flatId}`)
        .then(r => r.json())
        .then(tenant => {
            if (tenant) {
                document.getElementById('tenant_name').value = tenant.name + ' (' + tenant.phone + ')';
                document.getElementById('tenant_id').value   = tenant.id;
                document.getElementById('rent_amount').value = tenant.monthly_rent;
                document.getElementById('paid_amount').value = tenant.monthly_rent;
                calcDue();
            } else {
                document.getElementById('tenant_name').value = 'No active tenant in this flat';
            }
        });
}

function calcDue() {
    const rent = parseFloat(document.getElementById('rent_amount').value) || 0;
    const paid = parseFloat(document.getElementById('paid_amount').value) || 0;
    document.getElementById('due_display').value = Math.max(0, rent - paid);
}

function clearTenant() {
    document.getElementById('tenant_name').value = '';
    document.getElementById('tenant_id').value   = '';
    document.getElementById('rent_amount').value = '';
    document.getElementById('paid_amount').value = '';
    document.getElementById('due_display').value = '0';
}
</script>
@endsection